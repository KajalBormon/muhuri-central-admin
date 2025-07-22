<?php
namespace App\Services\Subscription;

use App\Services\APIService\Muhuri\MuhuriService;
use Carbon\Carbon;
use App\Models\Subscription\Subscription;
use App\Services\BaseModelService;
use Illuminate\Support\Facades\DB;
use App\Services\Subscription\SubscriptionHistoryService;

class SubscriptionService extends BaseModelService
{
    protected SubscriptionPlanService $subscriptionPlanService;
    protected SubscriptionHistoryService $subscriptionHistoryService;
    protected MuhuriService $muhuriService;

    public function __construct(SubscriptionPlanService $subscriptionPlanService, SubscriptionHistoryService $subscriptionHistoryService, MuhuriService $muhuriService)
    {
        $this->subscriptionPlanService = $subscriptionPlanService;
        $this->subscriptionHistoryService = $subscriptionHistoryService;
        $this->muhuriService = $muhuriService;
    }

    public function model(): string
    {
        return Subscription::class;
    }

    public function createSubscription($company, $subscriptionPlanId)
    {
        $result = DB::transaction(function () use ($company, $subscriptionPlanId) {
            $subscriptionPlan = $this->subscriptionPlanService->find($subscriptionPlanId);
            $validatedData = [
                'subscription_plan_id' => $subscriptionPlanId,
                'company_id' => $company->id,
                'start_date' => Carbon::now(),
                'end_date' => $this->calculateEndDate(Carbon::now(), $subscriptionPlan),
                'price' => $subscriptionPlan->price,
                'discount_amount' => $subscriptionPlan->discount_amount,
                'final_price' => $subscriptionPlan->price - $subscriptionPlan->discount_amount,
                'is_trial_taken' => true,
                'trial_start_date' => Carbon::now(),
                'trial_end_date' => $this->calculateEndDate(Carbon::now(), $subscriptionPlan),
            ];
            $subscription = $this->create($validatedData);

            if ($subscription) {
                $validatedData['subscription_id'] = $subscription->id;
                $this->subscriptionHistoryService->create($validatedData);
            }
            return $subscription;
        });
        return $result;
    }

    private function calculateEndDate($startDate, $plan)
    {
        $parsedStartDate = Carbon::parse($startDate);
        return ($plan->trial_duration ? $parsedStartDate->addMonths($plan->trial_duration) : $parsedStartDate->addMonths($plan->duration));
    }

    // Sync company initial subscription to the company
    public function syncSubscription($company, $subscription)
    {
        $data = [
            'subscription_plan_id' => $subscription->subscription_plan_id,
            'start_date' => Carbon::parse($subscription->start_date)->toDateString(),
            'end_date' => Carbon::parse($subscription->end_date)->toDateString(),
            'price' => $subscription->price,
            'discount_amount' => $subscription->discount_amount,
            'final_price' => $subscription->final_price,
            'is_trial_taken' => $subscription->is_trial_taken ?? 0,
            'trial_start_date' => $subscription->trial_start_date ? Carbon::parse($subscription->trial_start_date)->toDateString() : null,
            'trial_end_date' => $subscription->trial_end_date ? Carbon::parse($subscription->trial_end_date)->toDateString() : null,
        ];
        return $this->muhuriService->syncSubscription($data, $company);
    }

    // Update companies current subscription to central-admin
    public function updateSubscription($companyId, $validatedData)
    {
        $result = DB::transaction(function () use ($companyId, $validatedData) {
            $subscription = $this->model()::where('company_id', $companyId)->first();
            if ($subscription) {
                $isUpdated = $this->update($subscription, $validatedData);
                // Create subscription history
                if ($isUpdated) {
                    $validatedData['is_trial_taken'] = 0;
                    unset($validatedData['trial_start_date']);
                    unset($validatedData['trial_end_date']);

                    $validatedData['subscription_id'] = $subscription->id;
                    $validatedData['company_id'] = $subscription->company_id;
                    $this->subscriptionHistoryService->create($validatedData);
                }
                return $subscription;
            }
        });

        return $result;
    }
}
