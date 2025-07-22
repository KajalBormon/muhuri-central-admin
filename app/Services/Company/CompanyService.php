<?php

namespace App\Services\Company;

use App\Models\Company\Company;
use App\Services\BaseModelService;
use App\Services\ConfigurationService;

class CompanyService extends BaseModelService
{
    private ConfigurationService $configurationService;

    public function __construct(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    public function model(): string
    {
        return Company::class;
    }

    public function getCompanies()
    {
        return $this->model()::all();
    }

    public function getActiveCompaniesByCategoryId($categoryId, $isActive = true)
    {
        if($categoryId){
            return $this->model()::where('category_id', $categoryId)->where('is_active', $isActive)->get();
        }
        return $this->model()::where('is_active', $isActive)->get();
    }

    public function getCompaniesWithSubscription()
    {
        return $this->model()::with(['subscription.subscriptionPlan'])->get();
    }

    public function getCompanyDetails(Company $company)
    {
        return $company->load(['companyOnboardingStep','subscription.subscriptionPlan']);
    }

    public function createCompany($validatedData)
    {
        $domainAdminPortal = $this->configurationService->getConfiguration('domain_admin_portal');
        $companyAdminDomain = $validatedData['workspace']. '.' . $domainAdminPortal;
        $companyDomainsArray = [
            $companyAdminDomain => $companyAdminDomain
        ];

        $validatedData['email'] = $validatedData['mobile_number'] . '@muhuri.app';
        $validatedData['domain'] = $companyAdminDomain;
        $validatedData['allowed_domains'] = json_encode($companyDomainsArray);

        $company = $this->create($validatedData);
        return $company;
    }

    public function updateCompany($company, $validatedData): Company
    {
        $company->update($validatedData);
        return $company;
    }

    public function updateCompanyStatus($company, $status): void
    {
        $company->update(['status' => $status]);
    }

    public function getCompany($workspace)
    {
        return Company::where('workspace', $workspace)->first();
    }

    public function getCompanyOnboardingStepsStatus($company)
    {
        $steps = $company->companyOnboardingStep;

        return $steps &&
            $steps->company_created &&
            $steps->database_created &&
            $steps->database_migrated &&
            $steps->initial_data_loaded &&
            $steps->tenant_permission_synced &&
            $steps->tenant_role_synced &&
            $steps->user_created &&
            $steps->subscription_synced &&
            $steps->item_synced &&
            $steps->brand_synced &&
            $steps->fiscal_year_synced &&
            $steps->free_sms_added &&
            $steps->payment_method_synced &&
            $steps->job_position_synced &&
            $steps->departure_reason_synced;
    }

    public function markOnboardingCompleted($company)
    {
        $onboardingStatus = $this->getCompanyOnboardingStepsStatus($company);

        if($onboardingStatus) {
            $company->update(['is_onboarding_completed' => true]);
        }
    }
}
