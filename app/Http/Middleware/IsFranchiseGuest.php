<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsFranchiseGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdminAllowed == 1) {
                return redirect()->route('administrator.dashboard');
            } elseif ($user->is_franchise == 1) {
                return redirect()->route('franchise.dashboard');
            } elseif ($user->is_staff == 1 && $user->in_franchise == 1) {
                $user_role_type = $user->role->pluck('role_id')->toArray();
                if (empty(array_diff($user_role_type, [6])) || count($user_role_type) >= 2) {
                    return redirect()->route('franchise.management.manager.dashboard');
                }
                if (empty(array_diff($user_role_type, [7]))) {
                    return redirect()->route('franchise.management.publisher.dashboard');
                }
                if (empty(array_diff($user_role_type, [8]))) {
                    return redirect()->route('franchise.management.creater.dashboard');
                }

                return redirect()->route('management_login');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        return $next($request);
    }
}
