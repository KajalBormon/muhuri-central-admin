<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Subscritpion\UpdateSubscriptionRequest;
use App\Services\Company\CompanyService;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;
    protected CompanyService $companyService;
    
    public function __construct(SubscriptionService $subscriptionService, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->subscriptionService = $subscriptionService;
    }

    // API: Sync current subscription from company to central-admin
    public function syncSubscription(UpdateSubscriptionRequest $request)
    {
        $validatedData = $request->validated();
        $company = $this->companyService->getCompany($validatedData['workspace']);
        $this->subscriptionService->updateSubscription($company->id, $validatedData);
        return response()->json(['message' => 'Subscription synced successfully']);
    }
}
