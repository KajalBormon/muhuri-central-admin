<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Constants\Constants;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ActivityLogService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Services\Permission\RoleService;
use Illuminate\Support\Facades\Redirect;
use App\Services\AuthenticationLogService;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\User\UserPasswordUpdateRequest;

class UserController extends Controller implements HasMiddleware
{
    protected UserService $userService;
    protected RoleService $roleService;
    protected ActivityLogService $activityLogService;
    protected AuthenticationLogService $authenticationLogService;

    public function __construct(UserService $userService, RoleService $roleService, ActivityLogService $activityLogService, AuthenticationLogService $authenticationLogService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->activityLogService = $activityLogService;
        $this->authenticationLogService = $authenticationLogService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-user', only: ['create', 'store']),
            new Middleware('permission:can-edit-user', only: ['edit', 'update', 'updatePassword', 'changeStatus']),
            new Middleware('permission:can-delete-user', only: ['destroy']),
            new Middleware('permission:can-view-user', only: ['index']),
            new Middleware('permission:can-view-details-user', only: ['show']),
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('users');
        $users = $this->userService->getUsers();
        $roles = $this->roleService->getRoles();
        $responseData = [
            'users' => $users,
            'roles' => $roles,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.user.index'),
        ];
        return Inertia::render('User/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addUser');
        $roles = $this->roleService->getActiveRoles();
        $responseData = [
            'roles' => $roles,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.user.create'),
        ];
        return Inertia::render('User/Create', $responseData);
    }

    public function store(UserCreateRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->userService->createUser($validatedData);
        $status = $user ? Constants::SUCCESS : Constants::ERROR;
        $message = $user ? __('message.custom.user.store.success') : __('message.custom.user.store.error');
        return Redirect::route('users.index')->with($status, $message);
    }

    public function show(User $user)
    {
        $breadcrumbs = Breadcrumbs::generate('userDetails', $user);
        $user = $this->userService->getUserDetails($user);
        $roles = $this->roleService->getActiveRoles();
        $activityLogs = $this->activityLogService->getActivityLogs($user);
        $authenticationLogs = $this->authenticationLogService->getAuthenticationLogs($user);
        $responseData = [
            'user' => $user,
            'roles' => $roles,
            'breadcrumbs' => $breadcrumbs,
            'activityLogs' => $activityLogs,
            'authenticationLogs' => $authenticationLogs,
            'pageTitle' => __('pageTitle.custom.user.show'),
        ];
        return Inertia::render('User/Show', $responseData);
    }

    public function edit(User $user)
    {
        $breadcrumbs = Breadcrumbs::generate('editUser', $user);
        $roles = $this->roleService->getActiveRoles();
        $currentRoles = $user->roles;
        $responseData = [
            'user' => $user,
            'roles' => $roles,
            'currentRoles' => $currentRoles,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.user.edit'),
        ];
        return Inertia::render('User/Create', $responseData);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $user = $this->userService->getUserDetails($user);
        $isUpdated = $this->userService->updateUser($user, $validatedData);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.user.update.basic.success') : __('message.custom.user.basic.error');
        return Redirect::route('users.index')->with($status, $message);
    }

    public function updateDetails(UserUpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $user = $this->userService->getUserDetails($user);
        $isUpdated = $this->userService->updateUser($user, ['email' => $validatedData['email'], 'name' => $validatedData['name']]);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.user.update.updateDetails.success') : __('message.custom.user.updateDetails.error');
        return Redirect::back()->with($status, $message);
    }

    public function updateEmail(UserUpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $user = $this->userService->getUserDetails($user);
        $isUpdated = $this->userService->updateUser($user, ['email' => $validatedData['email']]);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.user.update.updateEmail.success') : __('message.custom.user.updateEmail.error');
        return Redirect::back()->with($status, $message);
    }

    public function updateRoles(UserUpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $user = $this->userService->getUserDetails($user);
        $isUpdated = $this->userService->updateUser($user, ['roles' => $validatedData['roles']]);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.user.update.updateRoles.success') : __('message.custom.user.updateRoles.error');
        return Redirect::back()->with($status, $message);
    }

    public function updatePassword(UserPasswordUpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $user = $this->userService->getUserDetails($user);
        $isUpdated = $this->userService->updatePassword($user, $validatedData);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.user.update.updatePassword.success') : __('message.custom.user.updatePassword.error');
        return Redirect::back()->with($status, $message);
    }

    public function destroy(User $user)
    {
        $user = $this->userService->getUserDetails($user);
        $isDeleted = $this->userService->deleteUser($user);
        $status = $isDeleted ? Constants::SUCCESS : Constants::ERROR;
        $message = $isDeleted ? __('message.custom.user.destroy.success') : __('message.custom.user.destroy.error');
        return Redirect::back()->with($status, $message);
    }

    /**
     * Change User Status
     */
    public function changeStatus(Request $request, User $user)
    {
        $user = $this->userService->getUserDetails($user);
        $user = $this->userService->changeStatus($user, $request->is_active);
        $status = Constants::SUCCESS;
        $message = $user->is_active ? __('message.custom.user.changeStatus.activate') : __('message.custom.user.changeStatus.deactivate');
        return Redirect::back()->with($status, $message);
    }
}
