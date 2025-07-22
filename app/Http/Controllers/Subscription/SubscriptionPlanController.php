<?php

namespace App\Http\Controllers\Subscription;

use App\Models\CompanyCategory;
use App\Services\Company\CompanyCategoryService;
use Exception;
use Inertia\Inertia;
use App\Constants\Constants;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Http\Controllers\Controller;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Redirect;
use App\Models\Subscription\SubscriptionPlan;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Services\Subscription\SubscriptionPlanService;
use App\Services\Subscription\SubscriptionPlanFeatureService;
use App\Http\Requests\Subscription\CreateSubscriptionPlanRequest;
use App\Http\Requests\Subscription\UpdateSubscriptionPlanRequest;

class SubscriptionPlanController extends Controller implements HasMiddleware
{
    protected SubscriptionPlanService $subscriptionPlanService;
    protected SubscriptionPlanFeatureService $subscriptionPlanFeatureService;
    protected CompanyCategoryService $companyCategoryService;

    public function __construct(SubscriptionPlanService $subscriptionPlanService, SubscriptionPlanFeatureService $subscriptionPlanFeatureService, CompanyCategoryService $companyCategoryService)
    {
        $this->subscriptionPlanService = $subscriptionPlanService;
        $this->subscriptionPlanFeatureService = $subscriptionPlanFeatureService;
        $this->companyCategoryService = $companyCategoryService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-subscription-plan', only: ['create', 'store']),
            new Middleware('permission:can-edit-subscription-plan', only: ['edit', 'update', 'changeStatus', 'featuresUpdate']),
            new Middleware('permission:can-view-subscription-plan', only: ['index']),
            new Middleware('permission:can-view-details-subscription-plan', only: ['show']),
        ];
    }

    public function index()
    {
        $subscriptionPlans = $this->subscriptionPlanService->getSubscriptionPlans();
        $breadcrumbs = Breadcrumbs::generate('subscriptionPlans');
        $responseData = [
            'subscriptionPlans' => $subscriptionPlans,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Subscription Plan List',
        ];

        return Inertia::render('Subscription/SubscriptionPlan/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addSubscriptionPlan');
        $planTypes = HelperService::getPlanTypes();
        $durationUnits = HelperService::getDurationUnits();
        $trialDurationUnits = HelperService::getDurationUnits();
        $companyCategories = $this->companyCategoryService->getCompanyCategoriesWithName();
        $responseData = [
            'planTypes' => $planTypes,
            'durationUnits' => $durationUnits,
            'trialDurationUnits' => $trialDurationUnits,
            'companyCategories' => $companyCategories,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Subscription Plan',
        ];
        return Inertia::render('Subscription/SubscriptionPlan/Create', $responseData);
    }

    public function store(CreateSubscriptionPlanRequest $request)
    {
        $validatedData = $request->validated();
        $subscriptionPlan = $this->subscriptionPlanService->create($validatedData);
        if ($subscriptionPlan) {
            try {
                $this->subscriptionPlanService->syncSubscriptionPlanAcrossCompanies($subscriptionPlan);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }
        $status = $subscriptionPlan ? Constants::SUCCESS : Constants::ERROR;
        $message = $subscriptionPlan ? 'Subscription plan created successfully' : 'Subscription plan could not be created';
        return Redirect::route('subscription-plans.index')->with($status, $message);
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        $breadcrumbs = Breadcrumbs::generate('subscriptionPlanDetails', $subscriptionPlan);
        $subscriptionPlan = $this->subscriptionPlanService->getSubscriptionPlanDetails($subscriptionPlan);
        $subscriptionPlanFeatures = $this->subscriptionPlanFeatureService->getActiveSubscriptionPlanFeatures();
        $responseData = [
            'subscriptionPlan' => $subscriptionPlan,
            'subscriptionPlanFeatures' => $subscriptionPlanFeatures,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Subscription Plan Details',
        ];
        return Inertia::render('Subscription/SubscriptionPlan/Show', $responseData);
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        $breadcrumbs = Breadcrumbs::generate('editSubscriptionPlan', $subscriptionPlan);
        $planTypes = HelperService::getPlanTypes();
        $durationUnits = HelperService::getDurationUnits();
        $trialDurationUnits = HelperService::getDurationUnits();
        $companyCategories = $this->companyCategoryService->getCompanyCategoriesWithName();
        $responseData = [
            'subscriptionPlan' => $subscriptionPlan,
            'planTypes' => $planTypes,
            'durationUnits' => $durationUnits,
            'trialDurationUnits' => $trialDurationUnits,
            'companyCategories' => $companyCategories,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Edit Subscription Plan',
        ];
        return Inertia::render('Subscription/SubscriptionPlan/Create', $responseData);
    }

    public function update(UpdateSubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->subscriptionPlanService->update($subscriptionPlan, $validatedData);
        if ($isUpdated) {
            try {
                $this->subscriptionPlanService->syncSubscriptionPlanAcrossCompanies($subscriptionPlan);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? 'Subscription plan updated successfully' : 'Subscription plan could not be updated';
        return Redirect::route('subscription-plans.show', $subscriptionPlan)->with($status, $message);
    }

    public function changeStatus(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan = $this->subscriptionPlanService->changeStatus($subscriptionPlan, $request->is_active);
        if ($subscriptionPlan) {
            try {
                $this->subscriptionPlanService->syncSubscriptionPlanAcrossCompanies($subscriptionPlan);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }
        $status = "success";
        $message = $subscriptionPlan->is_active ? 'Subscription plan is activated' : 'Subscription plan is deactivated';
        return Redirect::back()->with($status, $message);
    }

    public function featuresUpdate(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validatedData = $request->all();
        $subscriptionPlan = $this->subscriptionPlanService->featuresUpdate($subscriptionPlan, $validatedData);
        if ($subscriptionPlan) {
            try {
                $subscriptionPlanDetails = $this->subscriptionPlanService->getSubscriptionPlanDetails($subscriptionPlan);
                $this->subscriptionPlanService->syncSubscriptionPlanAcrossCompanies($subscriptionPlanDetails);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }

        $status = $subscriptionPlan ? Constants::SUCCESS : Constants::ERROR;
        $message = $subscriptionPlan ? 'Subscription plan feature updated successfully' : 'Subscription plan feature could not be updated';
        return Redirect::route('subscription-plans.show', $subscriptionPlan)->with($status, $message);
    }

    public function getSubscriptionPlansByCategory(CompanyCategory $companyCategory)
    {
        $subscriptionPlans = $this->subscriptionPlanService->getSubscriptionPlansByCategory($companyCategory);
        return response()->json($subscriptionPlans);
    }
}
