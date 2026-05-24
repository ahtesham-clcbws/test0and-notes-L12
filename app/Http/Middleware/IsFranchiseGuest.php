<?php

namespace App\Http\Middleware;

use App\Support\AuthRedirect;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsFranchiseGuest
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return AuthRedirect::homeFor(Auth::user());
        }

        return $next($request);
    }
}
