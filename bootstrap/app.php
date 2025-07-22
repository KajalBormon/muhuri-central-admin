<?php

use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\CheckIsFiscalYearEditable;
use Sentry\Laravel\Integration;
use App\Http\Middleware\Language;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckIsRoleDeletable;
use App\Http\Middleware\CheckIsRoleSuperAdmin;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Route middleware groups
        $middleware->web(append: [
            HandleInertiaRequests::class,
            Language::class,
        ]);

        // Middleware aliases
        $middleware->alias([
            'role.isSuperAdmin' => CheckIsRoleSuperAdmin::class,
            'role.isDeletable' => CheckIsRoleDeletable::class,
            'permission' => PermissionMiddleware::class,
            'api.key' => ApiKeyMiddleware::class,
            'check-fiscal-year.isEditable' => CheckIsFiscalYearEditable::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        Integration::handles($exceptions);
    })->create();
