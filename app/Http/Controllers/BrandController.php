<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\HelperService;
use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\BrandService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Http\Requests\Brand\CreateBrandRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BrandController extends Controller implements HasMiddleware
{
    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-view-brand', only: ['index']),
            new Middleware('permission:can-create-brand', only: ['create','store']),
            new Middleware('permission:can-edit-brand', only: ['edit','update']),
            new Middleware('permission:can-delete-brand', only: ['destroy']),
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('brands');
        $brands = $this->brandService->getBrands();
        $responseData = [
            'brands' => $brands,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.brand.index')
        ];

        return Inertia::render('Brand/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addBrand');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.brand.create')
        ];
        return Inertia::render('Brand/Create', $responseData);
    }

    public function store(CreateBrandRequest $request)
    {
        $validatedData = $request->validated();
        $brand = $this->brandService->create($validatedData);
        if($brand){
            try{
                $this->brandService->syncBrandAcrossCompanies($brand);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $brand ? 'success' : 'error';
        $message = $brand ? __('message.custom.brand.store.success') : __('message.custom.brand.store.error');
        return redirect()->route('brands.index')->with($status, $message);
    }

    public function edit(Brand $brand)
    {
        $breadcrumbs = Breadcrumbs::generate('editBrand', $brand);
        $responseData = [
            'brand' => $brand,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.brand.edit')
        ];

        return Inertia::render('Brand/Create', $responseData);
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->brandService->update($brand, $validatedData);
        if($isUpdated){
            try{
                $this->brandService->syncBrandAcrossCompanies($brand);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? 'success' : 'error';
        $message = $isUpdated ?  __('message.custom.brand.update.success') : __('message.custom.brand.update.error');
        return redirect()->route('brands.index')->with($status, $message);
    }

    public function destroy(Brand $brand)
    {
        $brand->deleted_by = auth()->id();
        $brand->save();
        $isDeleted = $this->brandService->deleteBrand($brand);
        if($isDeleted){
            try{
                $this->brandService->syncBrandDeleteAcrossCompanies($brand);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isDeleted ? 'success' : 'error';
        $message = $isDeleted ?  __('message.custom.brand.destroy.success') : __('message.custom.brand.destroy.error');
        return redirect()->route('brands.index')->with($status, $message);
    }

    public function changeStatus(Request $request, Brand $brand)
    {
        $brand = $this->brandService->changeStatus($brand, $request->is_active);
        if($brand){
            try{
                $this->brandService->syncBrandAcrossCompanies($brand);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status =  $brand ? 'success' : 'error';
        $message = $brand ? ($brand->is_active ? __('message.custom.brand.changeStatus.activate') : __('message.custom.brand.changeStatus.deactivate')) : __('message.custom.brand.changeStatus.error');
        return redirect()->back()->with($status, $message);
    }
}
