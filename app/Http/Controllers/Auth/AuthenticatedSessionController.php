<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Domains\Auth\Events\Login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'pageTitle' => "Login",
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Save last login.
        $user = $request->user();
        $user->last_login_at = Carbon::now();
        $user->save();
        $permissions = $user->getPermissionsViaRoles()->toArray();

        event(new Login($user));
        
        $request->session()->regenerate();
        // return redirect()->intended(RouteServiceProvider::HOME)->with('permissions', $permissions);
        return redirect()->route('dashboard')->with('permissions', $permissions);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
