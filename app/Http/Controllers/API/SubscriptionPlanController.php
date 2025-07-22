<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Subscription\SubscriptionPlanService;
use App\Services\Subscription\SubscriptionPlanFeatureService;

class SubscriptionPlanController extends Controller
{

    protected SubscriptionPlanService $subscriptionPlanService;
    protected SubscriptionPlanFeatureService $subscriptionPlanFeatureService;

    public function __construct(SubscriptionPlanService $subscriptionPlanService, SubscriptionPlanFeatureService $subscriptionPlanFeatureService)
    {
        $this->subscriptionPlanService = $subscriptionPlanService;
        $this->subscriptionPlanFeatureService = $subscriptionPlanFeatureService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptionPlans = $this->subscriptionPlanService->getActiveSubscriptionPlans();
        $subscriptionPlanFeatures = $this->subscriptionPlanFeatureService->getSubscriptionPlanFeatures();
        return response()->json([
            'subscriptionPlans' => $subscriptionPlans,
            'subscriptionPlanFeatures' => $subscriptionPlanFeatures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
