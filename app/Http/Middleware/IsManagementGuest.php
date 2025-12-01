<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsManagementGuest
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
        if(Auth::check()){
            // dd('hello');
            $user_role_type = Auth::user()->role->pluck('role_id')->toArray();
            //manager
            if (empty(array_diff($user_role_type,[6])) || count($user_role_type) >= 2) {
                return redirect()->route('franchise.management.manager.dashboard');
            }
            //publisher
            if (empty(array_diff($user_role_type,[7]))) {
                return redirect()->route('franchise.management.publisher.dashboard');
            }
            //creater
            if (empty(array_diff($user_role_type,[8]))) {
                return redirect()->route('franchise.management.creater.dashboard');
            }

            // Auth::logout();
            return redirect()->route('management_login');
            // return redirect()->route('franchise.management.dashboard');
        }
        Auth::logout();
        return $next($request);
    }
}
