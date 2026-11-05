<?php

namespace App\Http\Middleware;

use App\Support\AuthRedirect;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminGuest
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('administrator.dashboard'),
                ]);
            }

            return AuthRedirect::homeFor(Auth::user());
        }

        return $next($request);
    }
}
