<?php

namespace App\Services;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\Company\CompanyService;

class SyncService
{
    protected MuhuriService $muhuriService;
    protected CompanyService $companyService;
    public function __construct(MuhuriService $muhuriService, CompanyService $companyService)
    {
        $this->muhuriService = $muhuriService;
        $this->companyService = $companyService;
    }

    public function syncConfigurationAcrossCompanies($validatedData)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company) {
            $this->muhuriService->syncConfigurations($validatedData, $company);
        }
    }
}
