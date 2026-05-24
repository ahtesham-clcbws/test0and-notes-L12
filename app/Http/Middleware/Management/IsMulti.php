<?php

namespace App\Http\Middleware\Management;

use App\Http\Middleware\Concerns\ChecksContributorAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsMulti
{
    use ChecksContributorAccess;

    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user || ! $user->canAccessContributorPanel()) {
            Auth::logout();

            return redirect()->route('management_login')
                ->with('error', "You don't have contributor access.");
        }

        $roleIds = $user->contributorRoleIds();

        if (count($roleIds) > 1 && empty(array_diff($roleIds, [6, 7, 8]))) {
            return $next($request);
        }

        Auth::logout();

        return redirect()->route('management_login')->with('error', "You don't have Management access.");
    }
}
