<?php

namespace App\Services\FiscalYear;

use App\Models\FiscalYear;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\BaseModelService;
use App\Services\Company\CompanyService;
use Illuminate\Support\Facades\Cache;

class FiscalYearService extends BaseModelService
{
    protected MuhuriService $muhuriService;
    protected CompanyService $companyService;

    public function __construct(MuhuriService $muhuriService, CompanyService $companyService)
    {
        $this->muhuriService = $muhuriService;
        $this->companyService = $companyService;
    }

    public function model(): string
    {
        return FiscalYear::class;
    }

    public function getCurrentFiscalYear()
    {
        return $this->model()::where('status','running')->first();
    }

    public function getFiscalYearsByStatus($statuses = ['running','pending'])
    {
        return $this->model()::whereIn('status', $statuses)->get();
    }

    public function getActiveFiscalYears()
    {
        return $this->model()::where('is_active', true)->get();
    }

    public function getFiscalYears()
    {
        $cacheKey = 'fiscal_years';
        if(Cache::has($cacheKey)){
           return Cache::get($cacheKey);
        }
        $fiscalYears = $this->model()::whereIn('status',['running','end'])
            ->select('id','fiscal_year','start_date','end_date','status','is_active','note')
            ->get();

        Cache::put($cacheKey, $fiscalYears);
        return $fiscalYears;
    }

    public function getFiscalYearByYear($year)
    {
        return $this->model()::where('fiscal_year',$year)->first();
    }

    public function getFiscalYearByDate($date)
    {
        return $this->model()::where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();
    }

    public function getRunningFiscalYear()
    {
        return $this->model()::where('status', 'running')->first();
    }

    public function changeStatus(FiscalYear $fiscalYear, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $this->update($fiscalYear, ['is_active' => $isActive]);
        return $fiscalYear;
    }

    public function syncFiscalYears($company)
    {
        $fiscalYears = $this->getActiveFiscalYears();
        return $this->muhuriService->syncFiscalYears( $fiscalYears, $company);
    }

    public function syncFiscalYearAcrossCompanies(FiscalYear $fiscalYear)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company){
            $this->muhuriService->syncFiscalYears($fiscalYear, $company);
        }
    }
}
