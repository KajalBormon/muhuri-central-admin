<?php

namespace App\Http\Controllers\Permission;

use App\Models\User;
use Inertia\Inertia;
use App\Constants\Constants;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Services\Permission\RoleService;
use Illuminate\Support\Facades\Redirect;
use App\Services\Permission\PermissionService;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Permission\CreateRoleRequest;
use App\Http\Requests\Permission\UpdateRoleRequest;
use App\Http\Requests\Permission\AssignPermissionRequest;

class RoleController extends Controller implements HasMiddleware
{
    protected RoleService $roleService;
    protected PermissionService $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('role.isSuperAdmin', only: ['changeStatus']),
            new middleware('role.isDeletable', only: ['destroy']),
            new middleware('permission:can-create-role', only: ['create', 'store']),
            new Middleware('permission:can-edit-role', only: ['edit', 'update', 'changeStatus', 'removeUserFromRole']),
            new Middleware('permission:can-delete-role', only: ['destroy']),
            new Middleware('permission:can-view-role', only: ['index']),
            new Middleware('permission:can-view-details-role', only: ['show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('roles');
        $roles = $this->roleService->getRolesWithPermissions();
        $responseData = [
            'roles' => $roles,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.role.index'),
        ];
        return Inertia::render('Permission/Role/Index', $responseData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addRole');
        $permissions = $this->permissionService->getPermissions();
        $responseData = [
            'permissions' => $permissions,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.role.create'),
        ];
        return Inertia::render('Permission/Role/Create', $responseData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $validatedData = $request->validated();
        $role = $this->roleService->createRole($validatedData);
        $status = $role ? Constants::SUCCESS : Constants::ERROR;
        $message = $role ? __('message.custom.role.store.success') : __('message.custom.role.store.error');
        return Redirect::route('roles.index')->with($status, $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $breadcrumbs = Breadcrumbs::generate('roleDetails', $role);
        $role = $this->roleService->getRoleDetails($role);
        $users = $role->users;
        $responseData = [
            'role' => $role,
            'users' => $users,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.role.show'),
        ];
        return Inertia::render('Permission/Role/Show', $responseData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $breadcrumbs = Breadcrumbs::generate('editRole', $role);
        $permissions = $this->permissionService->getPermissions();
        $currentRolePermissions = $role->permissions;
        $responseData = [
            'role' => $role,
            'permissions' => $permissions,
            'currentRolePermissions' => $currentRolePermissions,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.role.edit'),
        ];
        return Inertia::render('Permission/Role/Create', $responseData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validatedData = $request->validated();
        $role = $this->roleService->getRoleDetails($role);
        $role = $this->roleService->updateRole($role, $validatedData);
        $status = $role ? Constants::SUCCESS : Constants::ERROR;
        $message = $role ? __('message.custom.role.update.success') : __('message.custom.role.update.error');
        return Redirect::route('roles.index')->with($status, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role = $this->roleService->getRoleDetails($role);
        $isDeleted = $this->roleService->deleteRole($role);
        $status = $isDeleted ? Constants::SUCCESS : Constants::ERROR;
        $message = $isDeleted ? __('message.custom.role.destroy.basic.success') : __('message.custom.role.destroy.basic.error');
        return Redirect::route('roles.index')->with($status, $message);
    }

    /**
     * Assign permission to a role
     */
    public function assignPermissionToRole(AssignPermissionRequest $request)
    {
        $validatedData = $request->validated();
        $rolePermission = $this->roleService->assignPermissionToRole($validatedData);
        return $rolePermission ? true : false;
    }

    /**
     * Remove assigned permission from roles
     */
    public function removePermissionFromRole(AssignPermissionRequest $request)
    {
        $validatedData = $request->validated();
        $rolePermission = $this->roleService->removePermissionFromRole($validatedData);
        return $rolePermission ? true : false;
    }

    /**
     * Change Role Status
     */
    public function changeStatus(Request $request, Role $role)
    {
        $role = $this->roleService->getRoleDetails($role);
        $result = $this->roleService->changeStatus($role, $request->is_active);
        $status = $result? Constants::SUCCESS : Constants::ERROR;
        $message = $result->is_active ? __('message.custom.role.changeStatus.activate') : __('message.custom.role.changeStatus.deactivate');
        return Redirect::route('roles.index')->with($status, $message);
    }

    public function removeUserFromRole(Role $role, User $user)
    {
        $role = $this->roleService->getRoleDetails($role);
        $isRemoved = $this->roleService->removeUserFromRole($role, $user);
        $status = $isRemoved ? Constants::SUCCESS : Constants::ERROR;
        $message = $isRemoved ? __('message.custom.role.destroy.removeUserFromRole.success') : __('message.custom.role.destroy.removeUserFromRole.error');
        return Redirect::back()->with($status, $message);
    }
}
