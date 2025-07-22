<?php

namespace App\Http\Controllers;

use App\Services\Company\CompanyCategoryService;
use Illuminate\Http\Request;

class CompanyCategoryController extends Controller
{
    private CompanyCategoryService $companyCategoryService;
    
    public function __construct(CompanyCategoryService $companyCategoryService)
    {
        $this->companyCategoryService = $companyCategoryService;
    }

    public function getCategories()
    {
        $categories = $this->companyCategoryService->getCompanyCategoriesWithName();
        return response()->json($categories);
    }
}
