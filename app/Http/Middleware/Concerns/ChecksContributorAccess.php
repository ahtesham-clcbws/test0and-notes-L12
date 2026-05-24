<?php

namespace App\Http\Middleware\Concerns;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait ChecksContributorAccess
{
    /**
     * @param  list<int>  $allowedRoleIds
     */
    protected function allowContributorWithRoles(Request $request, Closure $next, array $allowedRoleIds, bool $allowMultipleRoles = false): mixed
    {
        $user = Auth::user();

        if (! $user || ! $user->canAccessContributorPanel()) {
            Auth::logout();

            return redirect()->route('management_login')
                ->with('error', "You don't have contributor access.");
        }

        $roleIds = $user->contributorRoleIds();

        if ($roleIds === []) {
            Auth::logout();

            return redirect()->route('management_login')
                ->with('error', 'No contributor role assigned to your account.');
        }

        $allowed = $allowMultipleRoles
            ? (count($roleIds) >= 2 || empty(array_diff($roleIds, $allowedRoleIds)))
            : empty(array_diff($roleIds, $allowedRoleIds));

        if ($allowed) {
            return $next($request);
        }

        Auth::logout();

        return redirect()->route('management_login')
            ->with('error', "You don't have access to this area.");
    }
}
