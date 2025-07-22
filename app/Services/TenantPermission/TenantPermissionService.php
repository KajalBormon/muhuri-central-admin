<?php

namespace App\Services\TenantPermission;

use App\Models\TenantPermission;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\BaseModelService;
use App\Services\Company\CompanyService;
use Illuminate\Support\Facades\DB;

class TenantPermissionService extends BaseModelService
{
    protected CompanyService $companyService;
    protected MuhuriService $muhuriService;

    public function __construct(CompanyService $companyService, MuhuriService $muhuriService)
    {
        $this->companyService = $companyService;
        $this->muhuriService = $muhuriService;
    }

    public function model(): string
    {
        return TenantPermission::class;
    }

    public function getAllTenantPermissions()
    {
        return $this->model()::orderBy('id','desc')->get();
    }

    public function getActiveTenantPermissions($isActive = true)
    {
        $tenantPermissions = $this->model()::where('is_active', $isActive)->get();
        return $tenantPermissions;
    }

    public function getGroups()
    {
        return $this->model()::select('group_name')->groupBy('group_name')->get();
    }

    public function getTenantPermissions()
    {
        $tenantPermissions = $this->model()::where('guard_name', 'web')->get()->groupBy('group_name');
        return $tenantPermissions;
    }

    public function deleteTenantPermission($tenantPermission)
    {
        return DB::transaction(function () use ($tenantPermission) {
            $tenantPermission->name = $tenantPermission->name.'-'.'deleted'.'-'.$tenantPermission->id;
            $tenantPermission->deleted_by = auth()->user()->id;
            $tenantPermission->save();
            $tenantPermission->delete();
            return true;
        });
    }

    public function changeStatus(TenantPermission $tenantPermission, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $tenantPermission->is_active = $isActive;
        $tenantPermission->save();
        return $tenantPermission;
    }

    public function syncTenantPermissions($company)
    {
        $tenantPermissions = $this->getActiveTenantPermissions();
        return $this->muhuriService->syncTenantPermissions($tenantPermissions, $company);
    }

    public function syncTenantPermissionAcrossCompanies(TenantPermission $tenantPermission)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company){
            $this->muhuriService->syncTenantPermissions($tenantPermission, $company);
        }
    }

    public function syncTenantPermissionDeleteAcrossCompanies(TenantPermission $tenantPermission)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company){
            $this->muhuriService->syncTenantPermissionDelete($tenantPermission, $company);
        }
    }

}
