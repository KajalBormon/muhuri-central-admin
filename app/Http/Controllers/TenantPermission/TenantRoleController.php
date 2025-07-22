<?php

namespace App\Http\Controllers\TenantPermission;

use App\Constants\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantPermission\CreateTenantRoleRequest;
use App\Http\Requests\TenantPermission\UpdateTenantRoleRequest;
use App\Models\TenantRole;
use App\Services\HelperService;
use App\Services\TenantPermission\TenantPermissionService;
use App\Services\TenantPermission\TenantRoleService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Redirect;

class TenantRoleController extends Controller
{
    protected TenantRoleService $tenantRoleService;
    protected TenantPermissionService $tenantPermissionService;

    public function __construct(TenantRoleService $tenantRoleService, TenantPermissionService $tenantPermissionService)
    {
        $this->tenantRoleService = $tenantRoleService;
        $this->tenantPermissionService = $tenantPermissionService;
    }

    public static function middleware(): array
    {
        return [
            new middleware('permission:can-create-tenant-role', only: ['create', 'store']),
            new Middleware('permission:can-edit-tenant-role', only: ['edit', 'update', 'changeStatus']),
            new Middleware('permission:can-view-tenant-role', only: ['index']),
            new Middleware('permission:can-view-details-tenant-role', only: ['show']),
            new Middleware('permission:can-delete-tenant-role', only: ['destroy'])
        ];
    }
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('tenantRoles');
        $tenantRoles = $this->tenantRoleService->getTenantRolesWithPermissions();

        $responseData = [
            'tenantRoles' => $tenantRoles,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Tenant Role List'
        ];

        return Inertia::render('TenantPermission/TenantRole/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addTenantRoles');
        $tenantPermissions = $this->tenantPermissionService->getTenantPermissions();

        $responseData = [
            'tenantPermissions' => $tenantPermissions,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Tenant Role'
        ];

        return Inertia::render('TenantPermission/TenantRole/Create', $responseData);
    }

    public function store(CreateTenantRoleRequest $request)
    {
        $validatedData = $request->validated();
        $tenantRole = $this->tenantRoleService->createTenantRole($validatedData);
        if($tenantRole){
            try{
                $this->tenantRoleService->syncTenantRoleAcrossCompanies($tenantRole);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $tenantRole ? Constants::SUCCESS : Constants::ERROR;
        $message = $tenantRole ? "Tenant role created successfully" : "Tenant Role could not be created";
        return Redirect::route('tenant-roles.index')->with($status, $message);
    }

    public function show(TenantRole $tenantRole)
    {
        $breadcrumbs = Breadcrumbs::generate('tenantRoleDetails', $tenantRole);
        $tenantRole = $this->tenantRoleService->getTenantRoleDetails($tenantRole);

        $responseData = [
            'tenantRole' => $tenantRole,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => "Tenant Role Details",
        ];

        return Inertia::render('TenantPermission/TenantRole/Show', $responseData);
    }

    public function edit(TenantRole $tenantRole)
    {
        $breadcrumbs = Breadcrumbs::generate('editTenantRole', $tenantRole);
        $tenantPermissions = $this->tenantPermissionService->getTenantPermissions();
        $currentTenantRolePermissions = $tenantRole->permissions;

        $responseData = [
            'tenantRole' => $tenantRole,
            'tenantPermissions' => $tenantPermissions,
            'currentTenantRolePermissions' => $currentTenantRolePermissions,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => "Edit Tenant Role",
        ];

        return Inertia::render('TenantPermission/TenantRole/Create', $responseData);
    }

    public function update(UpdateTenantRoleRequest $request, TenantRole $tenantRole)
    {
        $validatedData = $request->validated();
        $tenantRole = $this->tenantRoleService->getTenantRoleDetails($tenantRole);
        $isUpdated = $this->tenantRoleService->updateTenantRole($tenantRole, $validatedData);
        if($isUpdated){
            try{
                $this->tenantRoleService->syncTenantRoleAcrossCompanies($tenantRole);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? "Tenant role updated successfully" : "Tenant role could not be updated";
        return Redirect::route('tenant-roles.index')->with($status, $message);
    }

    public function destroy(TenantRole $tenantRole)
    {
        $tenantRole = $this->tenantRoleService->getTenantRoleDetails($tenantRole);
        $isDeleted = $this->tenantRoleService->deleteTenantRole($tenantRole);
        if($isDeleted){
            try{
                $this->tenantRoleService->syncTenantRoleDeleteAcrossCompanies($tenantRole);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isDeleted ? Constants::SUCCESS : Constants::ERROR;
        $message = $isDeleted ? "Tenant role deleted successfully" : "Tenant role could not be deleted";
        return Redirect::route('tenant-roles.index')->with($status, $message);
    }

    public function changeStatus(Request $request, TenantRole $tenantRole)
    {
        $tenantRole = $this->tenantRoleService->getTenantRoleDetails($tenantRole);
        $result = $this->tenantRoleService->changeStatus($tenantRole, $request->is_active);
        if($result){
            try{
                $this->tenantRoleService->syncTenantRoleAcrossCompanies($tenantRole);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $result? Constants::SUCCESS : Constants::ERROR;
        $message = $result->is_active ? "Tenant status is activated" : "Tenant status is deactivated";
        return Redirect::route('tenant-roles.index')->with($status, $message);
    }
}
