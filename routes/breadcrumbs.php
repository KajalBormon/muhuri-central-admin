<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Brand;
use App\Models\Company\Company;
use App\Models\FiscalYear;
use App\Models\Item\Item;
use App\Models\PaymentMethod;
use App\Models\Subscription\SubscriptionPlan;
use App\Models\Subscription\SubscriptionPlanFeature;
use App\Models\TenantPermission;
use App\Models\TenantRole;
use App\Models\User;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Spatie\Permission\Models\Role;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Permission;

// Dashboard as Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(__('pageTitle.custom.home'), route('dashboard'));
});

// Settings
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.configuration.parentInfo'), route('configurations.details'));
});

// Settings - Basic Info
Breadcrumbs::for('settingsBasicInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.basicInfo'), route('configurations.basicInfo'));
});

// Settings - Additional Info
Breadcrumbs::for('settingsAdditionalInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.additionalInfo'), route('configurations.additionalInfo'));;
});

// Settings - Contact Info
Breadcrumbs::for('settingsContactInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.contactInfo'), route('configurations.contactInfo'));
});

// Settings - Global Info
Breadcrumbs::for('settingsGlobalInfo', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.globalInfo'), route('configurations.globalInfo'));
});

// Settings - SMS Service
Breadcrumbs::for('settingsSmsService', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(__('breadcrumb.custom.configuration.childInfo.smsService'), route('configurations.smsService'));
});

// User Management Menu
Breadcrumbs::for('userManagement', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.user.parentInfo'));
});

// Permissions
Breadcrumbs::for('permissions', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.permission.childInfo.index'), route('permissions.index'));
});

// Add Permission
Breadcrumbs::for('addPermission', function (BreadcrumbTrail $trail) {
    $trail->parent('permissions');
    $trail->push(__('breadcrumb.custom.permission.childInfo.create'), route('permissions.create'));
});

// Edit Permission
Breadcrumbs::for('editPermission', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->parent('permissions');
    $trail->push(__('breadcrumb.custom.permission.childInfo.edit'), route('permissions.edit', $permission));
});

// Roles
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.role.childInfo.index'), route('roles.index'));
});

// Add Roles
Breadcrumbs::for('addRole', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.create'), route('roles.create'));
});

// Edit Roles
Breadcrumbs::for('editRole', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.edit'), route('roles.edit', $role));
});

// Roles Details
Breadcrumbs::for('roleDetails', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('roles');
    $trail->push(__('breadcrumb.custom.role.childInfo.details'), route('roles.show', $role));
});

// User List
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('userManagement');
    $trail->push(__('breadcrumb.custom.user.childInfo.index'), route('users.index'));
});

// Add User
Breadcrumbs::for('addUser', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.create'), route('users.create'));
});

// Edit User
Breadcrumbs::for('editUser', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.edit'), route('users.edit', $user));
});

// User Details
Breadcrumbs::for('userDetails', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push(__('breadcrumb.custom.user.childInfo.details'), route('users.show', $user));
});

// My Profile
Breadcrumbs::for('myProfile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.user.childInfo.profile'), route('profile.edit'));
});

// Companies
Breadcrumbs::for('companies', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Company List', route('companies.index'));
});

// Add Company
Breadcrumbs::for('addCompany', function (BreadcrumbTrail $trail) {
    $trail->parent('companies');
    $trail->push('Add', route('companies.create'));
});

// Company Onboarding
Breadcrumbs::for('companyOnboarding', function (BreadcrumbTrail $trail, Company $company) {
    $trail->parent('companies');
    $trail->push('Company Onboarding', route('companies.onboarding.index', $company));
});

// Company Details
Breadcrumbs::for('companyDetails', function (BreadcrumbTrail $trail, Company $company) {
    $trail->parent('companies');
    $trail->push('Details', route('companies.show', $company));
});

//Parent Items
Breadcrumbs::for('parentItems', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('Items'), route('items.index'));
});

//Type wise Items
Breadcrumbs::for('items', function (BreadcrumbTrail $trail, $itemType) {
    $titles = [
        'sale' => 'Sale',
        'purchase' => 'Purchase',
        'expense' => 'Expense',
    ];
    $trail->parent('parentItems');
    $trail->push($titles[$itemType], route('items.index', ['itemType' => $itemType]));
});

//Edit items
Breadcrumbs::for('editItem', function (BreadcrumbTrail $trail, $itemType, Item $item) {

    $trail->parent('items', $itemType);
    $trail->push('Edit ', route('items.edit',$item));
});

//Brand Menu
Breadcrumbs::for('allBrands', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumb.custom.brand.parentInfo'), route('brands.index'));
});

//Brand List
Breadcrumbs::for('brands', function (BreadcrumbTrail $trail) {
    $trail->parent('allBrands');
    $trail->push(__('breadcrumb.custom.brand.childInfo.index'), route('brands.index'));
});

//Add Brand
Breadcrumbs::for('addBrand', function (BreadcrumbTrail $trail) {
    $trail->parent('brands');
    $trail->push(__('breadcrumb.custom.brand.childInfo.create'), route('brands.create'));
});

//Edit Brand
Breadcrumbs::for('editBrand', function (BreadcrumbTrail $trail, Brand $brand) {
    $trail->parent('brands');
    $trail->push(__('breadcrumb.custom.brand.childInfo.edit'), route('brands.edit', $brand));
});

// Job Position List
Breadcrumbs::for('jobPositions', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Job Position', route('job-positions.index'));
});

// Fiscal Year List
Breadcrumbs::for('fiscalYears', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Fiscal Years', route('fiscal-years.index'));
});

// Add Fiscal Year
Breadcrumbs::for('addFiscalYear', function (BreadcrumbTrail $trail) {
    $trail->parent('fiscalYears');
    $trail->push('Add Fiscal Year', route('fiscal-years.create'));
});

// Edit Fiscal Year
Breadcrumbs::for('editFiscalYear', function (BreadcrumbTrail $trail, FiscalYear $fiscalYear) {
    $trail->parent('fiscalYears');
    $trail->push('Edit Fiscal Year', route('fiscal-years.edit', $fiscalYear));
});

// Payment Method List
Breadcrumbs::for('paymentMethods', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Payment Methods', route('payment-methods.index'));
});

// Add Payment Method
Breadcrumbs::for('addPaymentMethod', function (BreadcrumbTrail $trail) {
    $trail->parent('paymentMethods');
    $trail->push('Add', route('payment-methods.create'));
});

// Edit Payment Method
Breadcrumbs::for('editPaymentMethod', function (BreadcrumbTrail $trail, PaymentMethod $paymentMethod) {
    $trail->parent('paymentMethods');
    $trail->push('Edit', route('payment-methods.edit', $paymentMethod));
});

// Subscription
Breadcrumbs::for('subscription', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Subscription', route('subscription-plans.index'));
});

// Subscription Plan List
Breadcrumbs::for('subscriptionPlans', function (BreadcrumbTrail $trail) {
    $trail->parent('subscription');
    $trail->push('Subscription Plan List', route('subscription-plans.index'));
});

// Add Subscription Plan
Breadcrumbs::for('addSubscriptionPlan', function (BreadcrumbTrail $trail) {
    $trail->parent('subscriptionPlans');
    $trail->push('Add', route('subscription-plans.create'));
});

// Edit Subscription Plan
Breadcrumbs::for('editSubscriptionPlan', function (BreadcrumbTrail $trail, SubscriptionPlan $subscriptionPlan) {
    $trail->parent('subscriptionPlans');
    $trail->push('Edit', route('subscription-plans.edit', $subscriptionPlan));
});

// Subscription Plan Details
Breadcrumbs::for('subscriptionPlanDetails', function (BreadcrumbTrail $trail, SubscriptionPlan $subscriptionPlan) {
    $trail->parent('subscriptionPlans');
    $trail->push('Details', route('subscription-plans.show', $subscriptionPlan));
});

// Subscription Plan Feature List
Breadcrumbs::for('subscriptionPlanFeatures', function (BreadcrumbTrail $trail) {
    $trail->parent('subscription');
    $trail->push('Subscription Plan Feature List', route('subscription-plan-features.index'));
});

// Add Subscription Plan Feature
Breadcrumbs::for('addSubscriptionPlanFeature', function (BreadcrumbTrail $trail) {
    $trail->parent('subscriptionPlanFeatures');
    $trail->push('Add', route('subscription-plan-features.create'));
});

// Edit Subscription Plan Feature
Breadcrumbs::for('editSubscriptionPlanFeature', function (BreadcrumbTrail $trail, SubscriptionPlanFeature $subscriptionPlanFeature) {
    $trail->parent('subscriptionPlanFeatures');
    $trail->push('Edit', route('subscription-plan-features.edit', $subscriptionPlanFeature));
});

// Tenant Role and Permission
Breadcrumbs::for('tenant', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Tenant Management', route('tenant-permissions.index'));
});

// Tenant Permission
Breadcrumbs::for('tenantPermissions', function (BreadcrumbTrail $trail) {
    $trail->parent('tenant');
    $trail->push('Tenant Permissions', route('tenant-permissions.index'));
});

// Tenant Permission List
Breadcrumbs::for('addTenantPermission', function (BreadcrumbTrail $trail) {
    $trail->parent('tenantPermissions');
    $trail->push('Add', route('tenant-permissions.create'));
});

// Edit Tenant Permission
Breadcrumbs::for('editTenantPermission', function (BreadcrumbTrail $trail, TenantPermission $tenantPermission) {
    $trail->parent('tenantPermissions');
    $trail->push('Edit', route('tenant-permissions.edit', $tenantPermission));
});

// Tenant Roles
Breadcrumbs::for('tenantRoles', function (BreadcrumbTrail $trail) {
    $trail->parent('tenant');
    $trail->push('Tenant Roles', route('tenant-roles.index'));
});

// Tenant Role List
Breadcrumbs::for('addTenantRoles', function (BreadcrumbTrail $trail) {
    $trail->parent('tenantRoles');
    $trail->push('Add', route('tenant-roles.create'));
});

// Edit Tenant Role
Breadcrumbs::for('editTenantRole', function (BreadcrumbTrail $trail, TenantRole $tenantRole) {
    $trail->parent('tenantRoles');
    $trail->push('Edit', route('tenant-roles.edit', $tenantRole));
});

// Edit Tenant Role
Breadcrumbs::for('tenantRoleDetails', function (BreadcrumbTrail $trail, TenantRole $tenantRole) {
    $trail->parent('tenantRoles');
    $trail->push('Details', route('tenant-roles.edit', $tenantRole));
});

// Departure Reason List
Breadcrumbs::for('departureReasons', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Departure Reason', route('departure-reasons.index'));
});
