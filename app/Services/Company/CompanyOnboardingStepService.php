<?php

namespace App\Services\Company;

use App\Models\Company\Company;
use App\Models\Company\CompanyOnboardingStep;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\APIService\Muhuri\MuhuriTenantCreateService;
use App\Services\BaseModelService;
use App\Services\BrandService;
use App\Services\ConfigurationService;
use App\Services\DatabaseManagementService;
use App\Services\DepartureReasonService;
use App\Services\FiscalYear\FiscalYearService;
use App\Services\Item\ItemService;
use App\Services\JobPositionService;
use App\Services\PaymentMethodService;
use App\Services\Subscription\SubscriptionPlanFeatureService;
use App\Services\Subscription\SubscriptionPlanService;
use App\Services\Subscription\SubscriptionService;
use App\Services\TenantPermission\TenantPermissionService;
use App\Services\TenantPermission\TenantRoleService;
use App\Services\TenantService;
use Illuminate\Support\Facades\DB;

class CompanyOnboardingStepService extends BaseModelService
{
    protected TenantService $tenantService;
    protected MuhuriTenantCreateService $muhuriTenantCreateService;
    protected DatabaseManagementService $databaseManagementService;
    protected SubscriptionPlanFeatureService $subscriptionPlanFeatureService;
    protected SubscriptionPlanService $subscriptionPlanService;
    protected SubscriptionService $subscriptionService;
    protected CompanyService $companyService;
    protected ItemService $itemService;
    protected BrandService $brandService;
    protected FiscalYearService $fiscalYearService;
    protected ConfigurationService $configurationService;
    protected MuhuriService $muhuriService;
    protected PaymentMethodService $paymentMethodService;
    protected JobPositionService $jobPositionService;
    protected TenantPermissionService $tenantPermissionService;
    protected TenantRoleService $tenantRoleService;
    protected DepartureReasonService $departureReasonService;

    public function __construct(
        TenantService $tenantService,
        MuhuriTenantCreateService $muhuriTenantCreateService,
        DatabaseManagementService $databaseManagementService,
        SubscriptionPlanFeatureService $subscriptionPlanFeatureService,
        SubscriptionPlanService $subscriptionPlanService,
        SubscriptionService $subscriptionService,
        CompanyService $companyService,
        ItemService $itemService, BrandService $brandService,
        FiscalYearService $fiscalYearService,
        ConfigurationService $configurationService,
        MuhuriService $muhuriService,
        PaymentMethodService $paymentMethodService,
        JobPositionService $jobPositionService,
        TenantPermissionService $tenantPermissionService,
        TenantRoleService $tenantRoleService,
        DepartureReasonService $departureReasonService
    ) {
        $this->tenantService = $tenantService;
        $this->muhuriTenantCreateService = $muhuriTenantCreateService;
        $this->databaseManagementService = $databaseManagementService;
        $this->subscriptionPlanFeatureService = $subscriptionPlanFeatureService;
        $this->subscriptionPlanService = $subscriptionPlanService;
        $this->subscriptionService = $subscriptionService;
        $this->companyService = $companyService;
        $this->itemService = $itemService;
        $this->brandService = $brandService;
        $this->fiscalYearService = $fiscalYearService;
        $this->configurationService = $configurationService;
        $this->muhuriService = $muhuriService;
        $this->paymentMethodService = $paymentMethodService;
        $this->jobPositionService = $jobPositionService;
        $this->tenantPermissionService = $tenantPermissionService;
        $this->tenantRoleService = $tenantRoleService;
        $this->departureReasonService = $departureReasonService;
    }

    public function model(): string
    {
        return CompanyOnboardingStep::class;
    }

    public function updateOnboardingStep($company, $validatedData)
    {
        $companyOnboardingStep = $this->model()::firstOrCreate(
            ['company_id' => $company->id]
        );
        $this->update($companyOnboardingStep, $validatedData);
    }

    public function createTenant($company)
    {
        $tenant = $this->tenantService->createTenant($company);

        if($tenant) {
            $this->updateOnboardingStep($company, [
                'company_created' => true
            ]);
        }
    }

    public function createTenantDatabase($company)
    {
        $validatedDatabaseData = $this->databaseManagementService->createTenantDatabase($company->workspace);
        $tenantDatabase = $this->tenantService->createTenantDatabase($company, $validatedDatabaseData);

        if($tenantDatabase) {
            $this->updateOnboardingStep($company, [
                'database_created' => true
            ]);
        }
    }

    public function migrateDatabase($company)
    {
        DB::transaction(function () use ($company) {
            $migrateDatabase = $this->muhuriTenantCreateService->migrateDatabase($company);

            if($migrateDatabase) {
                $this->updateOnboardingStep($company, [
                    'database_migrated' => true
                ]);
            }
        });
    }

    public function loadInitialData($company)
    {
        DB::transaction(function () use ($company) {
            $initialData = $this->muhuriTenantCreateService->loadInitialData($company);

            if($initialData) {
                $this->updateOnboardingStep($company, [
                    'initial_data_loaded' => true
                ]);
            }
        });
    }

    public function createAdminUser($company, $validatedData = null)
    {
        $password = $validatedData['password'] ?? $this->databaseManagementService->generatePassword();
        $userCreateData = [
            'name' => $validatedData['name'] ?? $company->name,
            'email' => $company->email,
            'mobile_number' => $validatedData['mobile_number'] ?? $company->mobile_number,
            'password' => $password,
            'workspace' => $company->workspace
        ];
        unset($validatedData['password']);

        $adminUser = $this->muhuriTenantCreateService->createAdminUser($company, $userCreateData);

        if($adminUser) {
            $this->updateOnboardingStep($company, [
                'user_created' => true
            ]);
        }
    }

    public function syncSubscription($company, $subscription)
    {
        DB::transaction(function () use ($company, $subscription) {
            $subscriptionPlanFeature = $this->subscriptionPlanFeatureService->syncSubscriptionPlanFeatures($company);
            $subscriptionPlan = $this->subscriptionPlanService->syncSubscriptionPlans($company);
            $subscription = $this->subscriptionService->syncSubscription($company, $subscription);

            if(($subscriptionPlan && $subscription) || $subscriptionPlanFeature) {
                $this->updateOnboardingStep($company, [
                    'subscription_synced' => true
                ]);
            }
        });
    }

    public function syncItems($company)
    {
        $item = $this->itemService->syncItems($company);
        if($item) {
            $this->updateOnboardingStep($company, [
                'item_synced' => true
            ]);
        }
    }

    public function syncBrands($company)
    {
        $brands = $this->brandService->syncBrands($company);
        if($brands){
            $this->updateOnboardingStep($company, [
                'brand_synced' => true
            ]);
        }
    }

    public function syncFiscalYears($company)
    {
        $fiscalYear = $this->fiscalYearService->syncFiscalYears($company);
        if($fiscalYear){
            $this->updateOnboardingStep($company, [
                'fiscal_year_synced' => true
            ]);
        }
    }

    public function addFreeSMS($company)
    {
        $smsRate = $this->configurationService->getConfiguration('sms_rate');
        $smsQuantity = $this->configurationService->getConfiguration('free_sms_quantity');

        $smsData = [
            'sms_rate' => $smsRate,
            'free_sms_quantity' => $smsQuantity,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ];
        $sms = $this->muhuriService->addFreeSMS($smsData, $company);

        if($sms){
            $this->updateOnboardingStep($company, [
                'free_sms_added' => true
            ]);
        }
    }

    public function syncPaymentMethods($company)
    {
        $paymentMethods = $this->paymentMethodService->syncPaymentMethods($company);
        if($paymentMethods){
            $this->updateOnboardingStep($company, [
                'payment_method_synced' => true
            ]);
        }
    }

    public function syncJobPositions($company)
    {
        $jobPositions = $this->jobPositionService->syncJobPositions($company);
        if($jobPositions){
            $this->updateOnboardingStep($company, [
                'job_position_synced' => true
            ]);
        }
    }

    public function syncTenantPermissions($company)
    {
        $tenantPermissions = $this->tenantPermissionService->syncTenantPermissions($company);
        if($tenantPermissions){
            $this->updateOnboardingStep($company, [
                'tenant_permission_synced' => true
            ]);
        }
    }

    public function syncTenantRoles($company)
    {
        $tenantRoles = $this->tenantRoleService->syncTenantRoles($company);
        if($tenantRoles){
            $this->updateOnboardingStep($company, [
                'tenant_role_synced' => true
            ]);
        }
    }

    public function syncDepartureReasons($company)
    {
        $departureReasons = $this->departureReasonService->syncDepartureReasons($company);
        if($departureReasons){
            $this->updateOnboardingStep($company, [
                'departure_reason_synced' => true
            ]);
        }
    }

    public function handleOnboardingActions(string $onboardingStep, Company $company)
    {
        switch ($onboardingStep) {
            case 'database_migrated':
                $this->migrateDatabase($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'initial_data_loaded':
                $this->loadInitialData($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'tenant_permission_synced':
                $this->syncTenantPermissions($company);
                break;
            case 'tenant_role_synced':
                $this->syncTenantRoles($company);
                break;
            case 'user_created':
                $this->createAdminUser($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'subscription_synced':
                $this->syncSubscription($company, $company->subscription);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'item_synced':
                $this->syncItems($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'brand_synced':
                $this->syncBrands($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'fiscal_year_synced':
                $this->syncFiscalYears($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'free_sms_added':
                $this->addFreeSMS($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'payment_method_synced':
                $this->syncPaymentMethods($company);
                $this->companyService->markOnboardingCompleted($company);
                break;
            case 'job_position_synced':
                $this->syncJobPositions($company);
                break;
            case 'departure_reason_synced':
                $this->syncDepartureReasons($company);
                break;
            default:
                return;
        }
    }
}
