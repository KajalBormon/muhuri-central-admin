<?php

namespace App\Http\Controllers\Permission;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use App\Services\Permission\PermissionService;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;

class PermissionController extends Controller implements HasMiddleware
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public static function middleware(): array
    {
        return [
            new middleware('permission:can-create-permission', only: ['create', 'store']),
            new Middleware('permission:can-edit-permission', only: ['edit', 'update', 'changeStatus']),
            new Middleware('permission:can-view-permission', only: ['index']),
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('permissions');
        $permissions = $this->permissionService->getAllPermissions();
        $responseData = [
            'permissions' => $permissions,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.permission.index'),
        ];
        return Inertia::render('Permission/Permission/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addPermission');
        $groups = $this->permissionService->getGroups();
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'groups' => $groups,
            'pageTitle' => __('pageTitle.custom.permission.create'),
        ];
        return Inertia::render('Permission/Permission/Create', $responseData);
    }

    public function store(CreatePermissionRequest $request)
    {
        $validatedData = $request->validated();
        $permission = $this->permissionService->createPermission($validatedData);
        $status = $permission ? "success" : "error";
        $message = $permission ? __('message.custom.permission.store.success') : __('message.custom.permission.store.error');
        return Redirect::route('permissions.index')->with($status, $message);
    }

    public function edit(Permission $permission)
    {
        $breadcrumbs = Breadcrumbs::generate('editPermission', $permission);
        $groups = $this->permissionService->getGroups();
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'permission' => $permission,
            'groups' => $groups,
            'pageTitle' => __('pageTitle.custom.permission.edit'),
        ];
        return Inertia::render('Permission/Permission/Create', $responseData);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $validatedData = $request->validated();
        $permission = $this->permissionService->updatePermission($permission, $validatedData);
        $status = $permission ? "success" : "error";
        $message = $permission ? __('message.custom.permission.update.success') : __('message.custom.permission.update.error');
        return Redirect::route('permissions.index')->with($status, $message);
    }

    public function changeStatus(Request $request, Permission $permission)
    {
        $result = $this->permissionService->changeStatus($permission, $request->is_active);
        $status = "success";
        $message = $permission->is_active ? __('message.custom.permission.changeStatus.activate') : __('message.custom.permission.changeStatus.deactivate');
        return Redirect::back()->with($status, $message);
    }
}
