<?php

namespace App\Http\Controllers\Subscription;

use Exception;
use Inertia\Inertia;
use App\Constants\Constants;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Http\Controllers\Controller;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Models\Subscription\SubscriptionPlanFeature;
use App\Services\Subscription\SubscriptionPlanFeatureService;
use App\Http\Requests\Subscription\CreateSubscriptionPlanFeatureRequest;
use App\Http\Requests\Subscription\UpdateSubscriptionPlanFeatureRequest;

class SubscriptionPlanFeatureController extends Controller implements HasMiddleware
{
    protected SubscriptionPlanFeatureService $subscriptionPlanFeatureService;

    public function __construct(SubscriptionPlanFeatureService $subscriptionPlanFeatureService)
    {
        $this->subscriptionPlanFeatureService = $subscriptionPlanFeatureService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-subscription-plan-feature', only: ['create', 'store']),
            new Middleware('permission:can-edit-subscription-plan-feature', only: ['edit', 'update', 'changeStatus']),
            new Middleware('permission:can-view-subscription-plan-feature', only: ['index']),
            new Middleware('permission:can-view-details-subscription-plan-feature', only: ['show']),
        ];
    }

    public function index()
    {
        $subscriptionPlanFeatures = $this->subscriptionPlanFeatureService->getSubscriptionPlanFeatures();
        $breadcrumbs = Breadcrumbs::generate('subscriptionPlanFeatures');
        $responseData = [
            'subscriptionPlanFeatures' => $subscriptionPlanFeatures,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Subscription Plan Features List',
        ];

        return Inertia::render('Subscription/SubscriptionPlanFeature/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addSubscriptionPlanFeature');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Subscription Plan Feature',
        ];
        return Inertia::render('Subscription/SubscriptionPlanFeature/Create', $responseData);
    }

    public function store(CreateSubscriptionPlanFeatureRequest $request)
    {
        $validatedData = $request->validated();
        $subscriptionPlanFeature = $this->subscriptionPlanFeatureService->create($validatedData);
        if ($subscriptionPlanFeature) {
            try {
                $this->subscriptionPlanFeatureService->syncSubscriptionPlanFeatureAcrossCompanies($subscriptionPlanFeature);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }

        $status = $subscriptionPlanFeature ? Constants::SUCCESS : Constants::ERROR;
        $message = $subscriptionPlanFeature ? 'Subscription plan feature created successfully' : 'Subscription plan feature could not be created';
        return Redirect::route('subscription-plan-features.index')->with($status, $message);
    }

    public function edit(SubscriptionPlanFeature $subscriptionPlanFeature)
    {
        $breadcrumbs = Breadcrumbs::generate('editSubscriptionPlanFeature', $subscriptionPlanFeature);
        $responseData = [
            'subscriptionPlanFeature' => $subscriptionPlanFeature,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Edit Subscription Plan Feature',
        ];
        return Inertia::render('Subscription/SubscriptionPlanFeature/Create', $responseData);
    }

    public function update(UpdateSubscriptionPlanFeatureRequest $request, SubscriptionPlanFeature $subscriptionPlanFeature)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->subscriptionPlanFeatureService->update($subscriptionPlanFeature, $validatedData);
        if ($isUpdated) {
            try {
                $this->subscriptionPlanFeatureService->syncSubscriptionPlanFeatureAcrossCompanies($subscriptionPlanFeature);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }

        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? 'Subscription plan feature updated successfully' : 'Subscription plan feature could not be updated';
        return Redirect::route('subscription-plan-features.index')->with($status, $message);
    }

    public function changeStatus(Request $request, SubscriptionPlanFeature $subscriptionPlanFeature)
    {
        $subscriptionPlanFeature = $this->subscriptionPlanFeatureService->changeStatus($subscriptionPlanFeature, $request->is_active);
        if ($subscriptionPlanFeature) {
            try {
                $this->subscriptionPlanFeatureService->syncSubscriptionPlanFeatureAcrossCompanies($subscriptionPlanFeature);
            } catch (Exception $e) {
                HelperService::captureException($e);
            }
        }
        
        $status = Constants::SUCCESS;
        $message = $subscriptionPlanFeature->is_active ? 'Subscription plan feature is activated' : 'Subscription plan feature is deactivated';
        return Redirect::back()->with($status, $message);
    }
}
