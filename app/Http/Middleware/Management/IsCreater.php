<?php

namespace App\Http\Middleware\Management;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCreater
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && (Auth::user()->isAdminAllowed == 0 || Auth::user()->isAdminAllowed == 1) && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 1 && (Auth::user()->in_franchise == 1 || Auth::user()->in_franchise == 0) && Auth::user()->status == 'active'){
            if (empty(array_diff(Auth::user()->role->pluck('role_id')->toArray(),[8]))) {
                return $next($request);
            }

            Auth::logout();
            return redirect()->route('management_login')->with('error',"You don't have Admin access.");
        }

        Auth::logout();
        return redirect()->route('management_login')->with('error',"You don't have Management access.");
    }
}
