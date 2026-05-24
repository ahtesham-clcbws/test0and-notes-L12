<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->isSuperAdmin() && $user->status === 'active') {
            return $next($request);
        }

        Auth::logout();

        return redirect()->route('administrator.login')->with('error', "You don't have admin access.");
    }
}
