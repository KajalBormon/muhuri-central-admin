<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsFiscalYearEditable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $fiscalYear = $request->route('fiscal_year');

        // Check if the fiscal year is editable
        if($fiscalYear->status === 'end'){
            return redirect()->route('fiscal-years.index');
        }
        return $next($request);
    }
}
