<?php

namespace App\Http\Middleware;

use Closure;
use App\Constants\Constants;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsRoleSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->route('role');
        if($role->name === Constants::ROLE_SUPER_ADMIN) {
            return redirect()->back()->with('error', __('message.custom.role.changeStatus.error'));
        }
        return $next($request);
    }
}
