<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsManagement
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
        if(Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 1 && Auth::user()->in_franchise == 1 && Auth::user()->status == 'active'){
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('management_login')->with('error',"You don't have Management access.");
    }
}
