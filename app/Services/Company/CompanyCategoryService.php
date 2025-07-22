<?php

namespace App\Services\Company;

use App\Models\CompanyCategory;
use App\Services\BaseModelService;

class CompanyCategoryService extends BaseModelService
{
    public function model(): string
    {
        return CompanyCategory::class;
    }

    public function getCompanyCategories()
    {
        return $this->model()::all();
    }

    public function getActiveCompanyCategories($isActive = true)
    {
        return $this->model()::where('is_active', $isActive)->get();
    }

    public function getCompanyCategoriesWithName()
    {
        return $this->getActiveCompanyCategories()->map(function($category){
            return [
                'value' => $category->id,
                'text' => $category->name
            ];
        });
    }
}
