<?php

namespace App\Http\Controllers\TenantPermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantPermission\CreateTenantPermissionRequest;
use App\Http\Requests\TenantPermission\UpdateTenantPermissionRequest;
use App\Models\TenantPermission;
use App\Services\HelperService;
use App\Services\TenantPermission\TenantPermissionService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TenantPermissionController extends Controller implements HasMiddleware
{
    protected TenantPermissionService $tenantPermissionService;

    public function __construct(TenantPermissionService $tenantPermissionService)
    {
        $this->tenantPermissionService = $tenantPermissionService;
    }

    public static function middleware(): array
    {
        return [
            new middleware('permission:can-create-tenant-permission', only: ['create', 'store']),
            new Middleware('permission:can-edit-tenant-permission', only: ['edit', 'update', 'changeStatus']),
            new Middleware('permission:can-view-tenant-permission', only: ['index']),
        ];
    }
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('tenantPermissions');
        $tenantPermissions = $this->tenantPermissionService->getAllTenantPermissions();

        $responseData = [
            'tenantPermissions' => $tenantPermissions,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Tenant Permission List'
        ];

        return Inertia::render('TenantPermission/TenantPermission/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addTenantPermission');
        $groups = $this->tenantPermissionService->getGroups();

        $responseData = [
            'groups' => $groups,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Tenant Permission'
        ];

        return Inertia::render('TenantPermission/TenantPermission/Create', $responseData);
    }

    public function store(CreateTenantPermissionRequest $request)
    {
        $validatedData = $request->validated();
        $tenantPermission = $this->tenantPermissionService->create($validatedData);
        if($tenantPermission){
            try{
                $this->tenantPermissionService->syncTenantPermissionAcrossCompanies($tenantPermission);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $tenantPermission ? "success" : "error";
        $message = $tenantPermission ? "Tenant Permission Successfully Added" : "Tenant Permission could not be Added";
        return Redirect::route('tenant-permissions.index')->with($status, $message);
    }

    public function edit(TenantPermission $tenantPermission)
    {
        $breadcrumbs = Breadcrumbs::generate('editTenantPermission', $tenantPermission);
        $groups = $this->tenantPermissionService->getGroups();

        $responseData = [
            'tenantPermission' => $tenantPermission,
            'groups' => $groups,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Tenant Permission'
        ];

        return Inertia::render('TenantPermission/TenantPermission/Create', $responseData);
    }

    public function update(UpdateTenantPermissionRequest $request, TenantPermission $tenantPermission)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->tenantPermissionService->update($tenantPermission, $validatedData);
        if($isUpdated){
            try{
                $this->tenantPermissionService->syncTenantPermissionAcrossCompanies($tenantPermission);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? 'success' : 'error';
        $message = $isUpdated ? "Tenant permission successfully updated" : "Tenant permission could not be updated";
        return redirect()->route('tenant-permissions.index')->with($status, $message);
    }

    public function destroy(TenantPermission $tenantPermission)
    {
        $isDeleted = $this->tenantPermissionService->deleteTenantPermission($tenantPermission);
        if($isDeleted){
            try{
                $this->tenantPermissionService->syncTenantPermissionDeleteAcrossCompanies($tenantPermission);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isDeleted ? 'success' : 'error';
        $message = $isDeleted ? "Tenant permission successfully deleted" : "Tenant permission could not be deleted";
        return Redirect::route('tenant-permissions.index')->with($status, $message);
    }

    public function changeStatus(Request $request, TenantPermission $tenantPermission)
    {
        $tenantPermission = $this->tenantPermissionService->changeStatus($tenantPermission, $request->is_active);
        if($tenantPermission){
            try{
                $this->tenantPermissionService->syncTenantPermissionAcrossCompanies($tenantPermission);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = "success";
        $message = $tenantPermission->is_active ? "Tenant permission is activated" : "Tenant permission is deactivated";
        return Redirect::back()->with($status, $message);
    }
}
