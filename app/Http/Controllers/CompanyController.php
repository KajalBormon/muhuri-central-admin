<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyCreateRequest;
use App\Models\Company\Company;
use Inertia\Inertia;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Services\Company\CompanyService;
use App\Services\Company\CompanyOnboardingStepService;
use App\Services\HelperService;
use App\Services\SMS\OTPService;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller implements HasMiddleware
{
    protected CompanyService $companyService;
    protected CompanyOnboardingStepService $companyOnboardingStepService;
    protected SubscriptionService $subscriptionService;
    protected OTPService $otpService;

    public function __construct(CompanyService $companyService, CompanyOnboardingStepService $companyOnboardingStepService, SubscriptionService $subscriptionService, OTPService $otpService)
    {
        $this->companyService = $companyService;
        $this->companyOnboardingStepService = $companyOnboardingStepService;
        $this->subscriptionService = $subscriptionService;
        $this->otpService = $otpService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-view-company', only: ['index']),
            new Middleware('permission:can-create-company', only: ['create', 'store']),
            new Middleware('permission:can-view-details-company', only: ['getOnboardingStatus', 'redirectedTo', 'show']),
            new Middleware('permission:can-edit-company', only: ['updateOnboardingStatus', 'sendOTP', 'verifyOTP'])
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('companies');
        $companies = $this->companyService->getCompaniesWithSubscription();
        $responseData = [
            'companies' => $companies,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => "Company List"
        ];
        return Inertia::render('Company/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addCompany');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => "Create Company"
        ];
        return Inertia::render('Company/Create', $responseData);
    }

    public function store(CompanyCreateRequest $companyCreateRequest)
    {
        $validatedData = $companyCreateRequest->validated();

        try {
            # Create company
            $company = $this->companyService->createCompany($validatedData);

            # Create subscription and subscription history
            $subscription = $this->subscriptionService->createSubscription($company, $validatedData['subscription_plan_id']);

            # Create tenant
            $this->companyOnboardingStepService->createTenant($company);

            # Create tenant database
            $this->companyOnboardingStepService->createTenantDatabase($company);

            # Run database migrations
            $this->companyOnboardingStepService->migrateDatabase($company);

            # Load initial data
            $this->companyOnboardingStepService->loadInitialData($company);

            #Sync Tenant Permission
            $this->companyOnboardingStepService->syncTenantPermissions($company);

            #Sync Tenant Roles
            $this->companyOnboardingStepService->syncTenantRoles($company);

            # Create admin user
            $this->companyOnboardingStepService->createAdminUser($company, $validatedData);

            # Sync subscription
            $this->companyOnboardingStepService->syncSubscription($company, $subscription);

            # Sync Items
            $this->companyOnboardingStepService->syncItems($company);

            #Sync Brands
            $this->companyOnboardingStepService->syncBrands($company);

            #Sync FiscalYear
            $this->companyOnboardingStepService->syncFiscalYears($company);

            #Free SMS Added
            $this->companyOnboardingStepService->addFreeSMS($company);

            #Sync Payment Method
            $this->companyOnboardingStepService->syncPaymentMethods($company);

            # Sync Job Positions
            $this->companyOnboardingStepService->syncJobPositions($company);

            # Sync Departure Reasons
            $this->companyOnboardingStepService->syncDepartureReasons($company);

            # Mark Onboarding Completed
            $this->companyService->markOnboardingCompleted($company);

            return redirect()->route('companies.show', $company)->with('success', 'Company created successfully');
        } catch (\Exception $e) {
            HelperService::captureException($e);
            Log::error('Error occurred: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred during onboarding.');
        }
    }

    public function show(Company $company)
    {
        $breadcrumbs = Breadcrumbs::generate('companyDetails', $company);
        $company = $this->companyService->getCompanyDetails($company);
        $address = HelperService::getAddress($company);
        $responseData = [
            'company' => $company,
            'address' => $address,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => "Company Details"
        ];
        return Inertia::render('Company/Show', $responseData);
    }

    public function getOnboardingStatus($companyId)
    {
        $company = $this->companyService->findOrFail($companyId);
        $companyOnboardingStep = $company->companyOnboardingStep;

        return response()->json([
            'company_created' => $companyOnboardingStep->company_created,
            'database_created' => $companyOnboardingStep->database_created,
            'database_migrated' => $companyOnboardingStep->database_migrated,
            'initial_data_loaded' => $companyOnboardingStep->initial_data_loaded,
            'tenant_permission_synced' => $companyOnboardingStep->tenant_permission_synced,
            'tenant_role_synced' => $companyOnboardingStep->tenant_role_synced,
            'user_created' => $companyOnboardingStep->user_created,
            'subscription_synced' => $companyOnboardingStep->subscription_synced,
            'item_synced' => $companyOnboardingStep->item_synced,
            'brand_synced' => $companyOnboardingStep->brand_synced,
            'fiscal_year_synced' => $companyOnboardingStep->fiscal_year_synced,
            'free_sms_added' => $companyOnboardingStep->free_sms_added,
            'payment_method_synced' => $companyOnboardingStep->payment_method_synced,
            'job_position_synced' => $companyOnboardingStep->job_position_synced,
            'departure_reason_synced' => $companyOnboardingStep->departure_reason_synced
        ]);
    }

    public function updateOnboardingStatus(Request $request, Company $company)
    {
        $validated = $request->validate([
            'onboarding_step' => 'required|string|in:database_migrated,initial_data_loaded,tenant_permission_synced,tenant_role_synced,user_created,subscription_synced,item_synced,brand_synced,fiscal_year_synced,free_sms_added,payment_method_synced, job_position_synced,departure_reason_synced',
            'value' => 'required|boolean'
        ]);

        $onboardingStep = $company->companyOnboardingStep;
        if (!$onboardingStep) {
            return redirect()->route('companies.show', $company)->with([
                'status' => 'error',
                'message' => 'Onboarding step not found for this company.'
            ]);
        }

        $status = '';
        $message = '';
        if ($validated['value']) {
            $this->companyOnboardingStepService->handleOnboardingActions($validated['onboarding_step'], $company);
            $status = 'success';
            $message = "The '{$validated['onboarding_step']}' status has been updated successfully.";
        } else {
            $status = 'error';
            $message = "Failed to update the '{$validated['onboarding_step']}' status.";
        }
        return redirect()->route('companies.show', $company)->with($status, $message);
    }

    public function sendOTP(Request $request, Company $company)
    {
        $request->validate([
            'mobile_number' => 'required'
        ]);

        if ($company->is_active) {
            $this->otpService->sendOTP($company);
            return redirect()->back()->with('success', 'OTP is sent successfully');
        } else {
            return redirect()->back()->with('error', 'The company has been deactivated.');
        }
    }

    public function verifyOTP(Request $request, Company $company)
    {
        $request->validate([
            'mobile_number' => 'required',
            'otp' => 'required'
        ]);

        try {
            if ($this->otpService->verifyOTP($company, $request->otp)) {
                $company->mobile_number_verified_at = now();
                $company->save();
                return redirect()->back()->with('success', 'Company is verified now!');
            } else {
                return redirect()->back()->with('error', 'Your inserted OTP is invalid. Please try again...');
            }
        } catch (\Exception $e) {
            \Sentry\captureException($e);
            return redirect()->back()->with('error', 'An error occurred on the server. Please try again later');
        }
    }
}
