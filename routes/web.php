<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CompanyCategoryController;
use App\Http\Controllers\DepartureReasonController;
use App\Http\Controllers\TenantPermission\TenantPermissionController;
use App\Http\Controllers\TenantPermission\TenantRoleController;
use Inertia\Inertia;
use App\Http\Middleware\Language;
use Illuminate\Support\Facades\Route;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\FiscalYearController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\Permission\RoleController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Subscription\SubscriptionPlanController;
use App\Http\Controllers\Subscription\SubscriptionPlanFeatureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/localization/{locale}', [LocalizationController::class, 'localization'])->name('localization');
Route::get('/language-options', [LanguageController::class, 'getLanguageOptions'])->name('getLanguageOptions');


Route::middleware(Language::class)
    ->group(function () {

    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'pageTitle' => __('pageTitle.custom.login'),
        ]);
    })->middleware('guest');

    Route::get('/dashboard', function () {
        $breadcrumbs = Breadcrumbs::generate('dashboard');
        $permissions = session('permissions');
        $response = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.home'),
            'permissions' => $permissions
        ];
        return Inertia::render('Dashboard', $response);
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        // Profile related routes
        Route::prefix('profile')->group(function() {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        // Configuration related routes
        Route::prefix('configurations')->name('configurations.')->group(function() {
            Route::get('/', [ConfigurationController::class, 'details'])->name('details');
            Route::get('basic-info', [ConfigurationController::class, 'basicInfo'])->name('basicInfo');
            Route::get('additional-info', [ConfigurationController::class, 'additionalInfo'])->name('additionalInfo');
            Route::get('contact-info', [ConfigurationController::class, 'contactInfo'])->name('contactInfo');
            Route::get('global-info', [ConfigurationController::class, 'globalInfo'])->name('globalInfo');
            Route::get('sms-service', [ConfigurationController::class, 'smsService'])->name('smsService');

            Route::patch('basic-info', [ConfigurationController::class, 'updateBasicInfo'])->name('updateBasicInfo');
            Route::patch('additional-info', [ConfigurationController::class, 'updateAdditionalInfo'])->name('updateAdditionalInfo');
            Route::patch('contact-info', [ConfigurationController::class, 'updateContactInfo'])->name('updateContactInfo');
            Route::patch('global-info', [ConfigurationController::class, 'updateGlobalInfo'])->name('updateGlobalInfo');
            Route::patch('sms-service', [ConfigurationController::class, 'updateSmsService'])->name('updateSmsService');
        });

        // Permission related routes
        Route::resource('permissions', PermissionController::class)->except('show', 'destroy');
        Route::patch('permissions/{permission}/change-status', [PermissionController::class, 'changeStatus'])->name('permissions.changeStatus');

        // Roles related routes
        Route::resource('roles', RoleController::class);
        Route::post('assign-permission', [RoleController::class, 'assignPermissionToRole']);
        Route::delete('remove-assigned-permission', [RoleController::class, 'removePermissionFromRole']);
        Route::prefix('roles/{role}')->group(function() {
            Route::patch('change-status', [RoleController::class, 'changeStatus'])->name('roles.changeStatus');
            Route::delete('remove-user/{user}', [RoleController::class, 'removeUserFromRole'])->name('roles.removeUserFromRole');
        });

        // User related routes
        Route::resource('/users', UserController::class);
        Route::prefix('users/{user}')->group(function() {
            Route::patch('update-details', [UserController::class, 'updateDetails'])->name('users.updateDetails');
            Route::patch('update-email', [UserController::class, 'updateEmail'])->name('users.updateEmail');
            Route::patch('update-roles', [UserController::class, 'updateRoles'])->name('users.updateRoles');
            Route::patch('update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
            Route::patch('change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
        });

        // Company related routes
        Route::prefix('company-categories')->name('company.')->group(function(){
            Route::get('/', [CompanyCategoryController::class, 'getCategories'])->name('categories');
            Route::get('/{companyCategory}/subscription-plans', [SubscriptionPlanController::class, 'getSubscriptionPlansByCategory'])->name('subscriptionPlan');
        });

        Route::prefix('companies')->name('companies.')->group(function() {
            Route::resource('/', CompanyController::class)->parameters(['' => 'company'])->except('edit', 'update', 'destroy');
            Route::prefix('{company}/onboarding')->name('onboarding.')->group(function () {
                Route::prefix('status')->name('status.')->group(function () {
                    Route::get('/', [CompanyController::class, 'getOnboardingStatus'])->name('index');
                    Route::patch('/', [CompanyController::class, 'updateOnboardingStatus'])->name('update');
                });

                Route::prefix('otp')->name('otp.')->group(function () {
                    Route::post('/send', [CompanyController::class, 'sendOTP'])->name('send');
                    Route::post('/verify', [CompanyController::class, 'verifyOTP'])->name('verify');
                });
            });

        });

        //Items Related Route
        Route::resource('/items', ItemController::class)->except('show');
        Route::prefix('items')->name('items.')->group(function () {
            Route::prefix('{item}')->group(function(){
                Route::patch('/change-status', [ItemController::class, 'changeStatus'])->name('changeStatus');
                Route::prefix('item-units')->group(function(){
                    Route::get('/',[ItemController::class,'getItemUnits'])->name('getItemUnits');
                    Route::post('/',[ItemController::class,'storeItemUnit'])->name('storeItemUnit');
                });
            });
            Route::prefix('item-units/{itemUnit}')->group(function(){
                Route::patch('/', [ItemController::class, 'updateItemUnit'])->name('updateItemUnit');
                Route::delete('/', [ItemController::class, 'destroyItemUnit'])->name('destroyItemUnit');
            });
            Route::get('/get-by-type/{type}', [ItemController::class, 'getItemsByType'])->name('getItemsByType');
        });

        //Fiscal Year Related Route
        Route::resource('fiscal-years',FiscalYearController::class)->except('show','destroy');

        //FiscalYear Related
        Route::prefix('fiscal-years')->name('fiscal-years.')->group(function() {
            Route::prefix('{fiscal_year}')->group(function() {
                Route::patch('change-status', [FiscalYearController::class, 'changeStatus'])->name('changeStatus');
                Route::patch('start-fiscal-year',[FiscalYearController::class,'startFiscalYear'])->name('startFiscalYear');
                Route::patch('close-fiscal-year',[FiscalYearController::class,'closeFiscalYear'])->name('closeFiscalYear');
            });
        });

        // Subscription plan related routes
        Route::resource('/subscription-plans', SubscriptionPlanController::class);
        Route::prefix('subscription-plans/{subscription_plan}')->group(function() {
            Route::patch('change-status', [SubscriptionPlanController::class, 'changeStatus'])->name('subscription-plans.changeStatus');
            Route::patch('features', [SubscriptionPlanController::class, 'featuresUpdate'])->name('subscription-plans.featuresUpdate');
        });

        // Subscription plan feature related routes
        Route::resource('/subscription-plan-features', SubscriptionPlanFeatureController::class);
        Route::prefix('subscription-plan-features/{subscription_plan_feature}')->group(function() {
            Route::patch('change-status', [SubscriptionPlanFeatureController::class, 'changeStatus'])->name('subscription-plan-features.changeStatus');
        });

        //Brand related route
        Route::resource('/brands', BrandController::class);
        Route::patch('/brands/{brand}/change-status', [BrandController::class, 'changeStatus'])->name('brands.changeStatus');

        // Payment Method related route
        Route::resource('/payment-methods', PaymentMethodController::class);
        Route::patch('/payment-methods/{payment_method}/change-status', [PaymentMethodController::class, 'changeStatus'])->name('payment-methods.changeStatus');

        // Job-position related routes
        Route::resource('job-positions', JobPositionController::class);
        Route::patch('/job-positions/{job_position}/change-status', [JobPositionController::class, 'changeStatus'])->name('job-positions.changeStatus');

        //TenantPermission related route
        Route::resource('/tenant-permissions', TenantPermissionController::class)->except('show');
        Route::patch('tenant-permissions/{tenantPermission}/change-status', [TenantPermissionController::class, 'changeStatus'])->name('tenant-permissions.changeStatus');

        //Tenant Roles Related Route
        Route::resource('/tenant-roles', TenantRoleController::class);
        Route::patch('/tenant-roles/{tenantRole}/change-status', [TenantRoleController::class,'changeStatus'])->name('tenant-roles.changeStatus');

        // Departure-Reason related routes
        Route::resource('departure-reasons', DepartureReasonController::class);
        Route::patch('/departure-reasons/{departure_reason}/change-status', [DepartureReasonController::class, 'changeStatus'])->name('departure-reasons.changeStatus');
    });
});


require __DIR__ . '/auth.php';

