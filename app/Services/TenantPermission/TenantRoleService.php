<?php

namespace App\Services\TenantPermission;

use App\Models\TenantRole;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\BaseModelService;
use App\Services\Company\CompanyService;
use Illuminate\Support\Facades\DB;

class TenantRoleService extends BaseModelService
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
        return TenantRole::class;
    }

    public function getTenantRoles()
    {
        $roles = $this->model()::all();
        return $roles;
    }

    public function getActiveTenantRoles($isActive = true)
    {
        return $this->model()::where('is_active', $isActive)->get();
    }

    public function getTenantRolesWithPermissions()
    {
        $roles = $this->model()::with(['permissions'])->get();
        return $roles;
    }

    public function createTenantRole($validatedData)
    {
        $result = DB::transaction(function () use ($validatedData) {
            $tenantRole = $this->create($validatedData);
            if ($tenantRole) {
                $tenantRole->permissions()->sync($validatedData['tenant_permission_ids']);
            }
            return $tenantRole;
        });
        return $result;
    }

    public function getTenantRoleDetails(TenantRole $tenantRole)
    {
        $roleWithPermissions = $this->model()::with('permissions')->find($tenantRole->id);
        return $roleWithPermissions;
    }

    public function updateTenantRole(TenantRole $tenantRole, $validatedData)
    {
        $result = DB::transaction(function () use ($tenantRole, $validatedData) {
            $tenantRole->update($validatedData);
            $tenantRole->permissions()->sync($validatedData['tenant_permission_ids']);

            return $tenantRole;
        });
        return $result;
    }

    public function deleteTenantRole(TenantRole $tenantRole)
    {
        $result = DB::transaction(function () use ($tenantRole) {
            $tenantRole->name = $tenantRole->name .'-'. 'deleted' . '-' . $tenantRole->id;
            $tenantRole->deleted_by = auth()->user()->id;
            $tenantRole->save();
            $isDeleted = $tenantRole->delete();

            if ($isDeleted) {
                $tenantRole->permissions()->detach();
            }
            return $isDeleted;
        });
        return $result ? true : false;
    }

    public function changeStatus(TenantRole $tenantRole, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $tenantRole->is_active = $isActive;
        $tenantRole->save();
        return $tenantRole;
    }

    public function syncTenantRoles($company)
    {
        $tenantRoles = $this->getActiveTenantRoles();
        return $this->muhuriService->syncTenantRoles($tenantRoles, $company);
    }

    public function syncTenantRoleAcrossCompanies(TenantRole $tenantRole)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company){
            $this->muhuriService->syncTenantRoles($tenantRole, $company);
        }
    }

    public function syncTenantRoleDeleteAcrossCompanies(TenantRole $tenantRole)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company){
            $this->muhuriService->syncTenantRoleDelete($tenantRole, $company);
        }
    }

}
