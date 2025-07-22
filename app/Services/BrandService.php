<?php

namespace App\Services;

use App\Models\Brand;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\Company\CompanyService;
use Illuminate\Support\Facades\DB;

class BrandService extends BaseModelService
{
    private MuhuriService $muhuriService;
    private CompanyService $companyService;

    public function __construct(MuhuriService $muhuriService, CompanyService $companyService)
    {
        $this->muhuriService = $muhuriService;
        $this->companyService = $companyService;
    }

    public function model(): string
    {
        return Brand::class;
    }

    public function getBrands()
    {
        return $this->model()::orderBy('id','desc')->get();
    }

    public function getBrandById($brandId)
    {
        return $this->model()::select('name')->where('id', $brandId)->first();
    }

    public function changeStatus(Brand $brand, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $brand->is_active = $isActive;
        $brand->save();
        return $brand;
    }

    public function syncBrands($company)
    {
        $brands = $this->model()::where('is_active', true)->get();
        return $this->muhuriService->syncBrands($brands, $company);
    }

    public function syncBrandAcrossCompanies(Brand $brand)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncBrands($brand, $company);
        }
    }

    public function syncBrandDeleteAcrossCompanies(Brand $brand)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncBrandDelete($brand, $company);
        }
    }

    public function deleteBrand(Brand $brand)
    {
        return DB::transaction(function () use ($brand) {
            $brand->delete();
            $brand->deleted_by = auth()->user()->id;
            $brand->save();
            return true;
        });
    }
}
