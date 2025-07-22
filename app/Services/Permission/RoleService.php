<?php

namespace App\Services\Permission;

use App\Models\User;
use App\Services\BaseModelService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService extends BaseModelService
{
    public function model(): string
    {
        return Role::class;
    }
    public function getRoles()
    {
        $roles = $this->model()::all();
        return $roles;
    }
    public function getRolesWithPermissions()
    {
        $roles = $this->model()::with(['permissions', 'users'])->get();
        return $roles;
    }

    public function createRole($validatedData)
    {
        $result = DB::transaction(function () use ($validatedData) {
            $role = $this->create($validatedData);
            if ($role) {
                $role->syncPermissions($validatedData['permission_ids']);

                // Add the activity to activity_logs table
                $this->logActivity($role, 'created', 'created');
            }
            return $role;
        });
        return $result;
    }

    public function updateRole(Role $role, $validatedData)
    {
        $result = DB::transaction(function () use ($role, $validatedData) {
            $oldRole = clone $role;
            $role->update($validatedData);
            $role->syncPermissions($validatedData['permission_ids']);

            $isPermissionRemoved = array_diff($this->permissionIdsToArray($oldRole), $this->permissionIdsToArray($role));
            $isPermissionAdded = array_diff($this->permissionIdsToArray($role), $this->permissionIdsToArray($oldRole));

            if (($oldRole->name != $role->name) && ($isPermissionRemoved || $isPermissionAdded)) {
                // log if role name and permissions are updated
                $this->logActivity($role, 'updated', 'roleAndPermissions', $oldRole);
            } else if ($oldRole->name != $role->name) {
                // log if role name is updated
                $this->logActivity($role, 'updated', 'name', $oldRole);
            } else if ($isPermissionRemoved || $isPermissionAdded) {
                // log if permissions are updated
                $this->logActivity($role, 'updated', 'permissions', $oldRole);
            }
            return $role;
        });
        return $result;
    }

    /**
     * if role is deleted,
     * delete its assigned permissions
     * remove it from users.
     */
    public function deleteRole(Role $role)
    {
        $result = DB::transaction(function () use ($role) {
            $oldRole = clone $role;
            $isDeleted = $role->delete();

            if ($isDeleted) {
                $role->permissions()->detach();
                $role->users()->detach();

                // Add the activity to activity_logs table
                $this->logActivity($role, 'deleted', 'deleted', $oldRole);
            }
            return $isDeleted;
        });
        return $result ? true : false;
    }

    public function assignPermissionToRole($validatedData)
    {
        $roleId = $validatedData['role_id'];
        $permissionId = $validatedData['permission_id'];

        $role = $this->getRoleById($roleId);
        $permission = $this->getPermissionById($permissionId);

        if ($role->hasPermissionTo($permission)) {
            return false;
        }

        $role->givePermissionTo($permission);
        return true;
    }

    public function removePermissionFromRole($validatedData)
    {
        $roleId = $validatedData['role_id'];
        $permissionId = $validatedData['permission_id'];

        $role = $this->getRoleById($roleId);
        $permission = $this->getPermissionById($permissionId);

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return true;
        }

        return false;
    }

    public function getRoleById($roleId)
    {
        return Role::find($roleId);
    }

    public function getPermissionById($permissionId)
    {
        return Permission::find($permissionId);
    }

    public function getActiveRoles()
    {
        $roles = Role::where('is_active', 1)->where('is_available', 1)->get();
        return $roles->isEmpty() ? false : $roles;
    }

    public function changeStatus(Role $role, $isActive)
    {
        $result = DB::transaction(function () use ($role, $isActive) {
            $oldRole = clone $role;
            $isActive = ($isActive == true) ? false : true;
            $role->update(['is_active' => $isActive]);
            $role->users()->detach();

            // Add the activity to activity_logs table
            $this->logActivity($role, 'updated', 'status', $oldRole);
            return $role;
        });
        return $result;
    }

    public function getRoleDetails(Role $role)
    {
        $roleWithPermissions = $this->model()::with('permissions')->find($role->id);
        return $roleWithPermissions;
    }

    public function removeUserFromRole(Role $role, User $user)
    {
        $result = DB::transaction(function () use ($role, $user) {
            $role->users()->detach($user->id);
            $oldUser = [
                'name' => $user->name,
                'email' => $user->email,
            ];
            activity()
                ->performedOn($user)
                ->withProperties([
                    'old' => $oldUser
                ])
                ->event('deleted')
                ->log('Removed user - ' . $user->name . ' from role - ' . $role->name);
            return $role;
        });
        return $result;
    }

    protected function logActivity(Role $role, $event, $log, $oldRole = null)
    {
        if ($event === 'deleted' || $event === 'updated') {
            $properties['old'] = $this->extractRoleProperties($oldRole);
        }
        if ($event === 'created' || $event === 'updated') {
            $properties['attributes'] = $this->extractRoleProperties($role, $event);
        }
        $messageList = [
            'created' => "Created new role - $role->name",
            'roleAndPermissions' => "Updated the role and its permissions - $role->name",
            'name' => "Updated the role - $role->name",
            'permissions' => "Updated the permissions of - $role->name",
            'deleted' => "Deleted the role - $role->name",
            'status' => "Changed status of the role - $role->name"
        ];
        $message = $messageList[$log];
        activity()
            ->performedOn($role)
            ->event($event)
            ->withProperties($properties)
            ->log($message);
    }

    private function permissionIdsToArray(Role $role)
    {
        return $role->permissions->pluck('id')->toArray();
    }

    private function extractRoleProperties(Role $role, $event = null)
    {
        return [
            'role_id' => $role->id,
            'role_name' => $role->name,
            'guard_name' => $role->guard_name,
            'is_editable' => ($event === 'created') ? 1 : $role->is_editable,
            'is_available' => ($event === 'created') ? 1 : $role->is_available,
            'is_active' => ($event === 'created') ? 1 : $role->is_active,
            'permission_ids' => $this->permissionIdsToArray($role),
        ];
    }
}
