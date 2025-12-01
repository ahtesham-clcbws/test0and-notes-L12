<?php

namespace App\Http\Middleware\Management;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsManager
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
            $user_role_type = Auth::user()->role->pluck('role_id')->toArray();
            if (empty(array_diff([6],$user_role_type)) || count($user_role_type) >= 2) {
                return $next($request);
            }
            Auth::logout();
            return redirect()->route('management_login')->with('error',"You don't have Admion access.");
        }

        Auth::logout();
        return redirect()->route('management_login')->with('error',"You don't have Management access.");
    }
}
