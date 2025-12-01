<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if(Auth::check() && Auth::user()['isAdminAllowed'] == 1 && Auth::user()->status == 'active'){
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('administrator.login')->with('error',"You don't have admin access.");
    }
}
