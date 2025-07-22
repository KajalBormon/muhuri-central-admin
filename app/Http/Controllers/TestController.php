<?php

namespace App\Http\Controllers;

use App\Services\Subscription\SubscriptionPlanService;

class TestController extends Controller
{
    protected SubscriptionPlanService $subscriptionPlanService;

    public function __construct(SubscriptionPlanService $subscriptionPlanService)
    {
        $this->subscriptionPlanService = $subscriptionPlanService;
    }

    public function createSubscriptionPlans()
    {
        $subscriptionPlans = $this->subscriptionPlanService->updateOrCreate(
            [
                'name' => 'Test Plan',
                'description' => 'Test Plan Description',
                'price' => 100,
                'duration' => 1,
                'duration_unit' => 'month',
                'trial_duration' => 0,
                'trial_duration_unit' => 'month',
                'discount_amount' => 0,
                'note' => 'Test Plan Note',
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        return response()->json([
            'subscription_plans' => $subscriptionPlans
        ]);
    }
}
