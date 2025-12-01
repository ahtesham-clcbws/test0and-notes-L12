<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsFranchise
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 1 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active'){
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('franchise.login')->with('error',"You don't have admin access.");
    }
}
