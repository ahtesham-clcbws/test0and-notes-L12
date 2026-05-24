<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AuthRedirect
{
    public static function homeFor(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('administrator.dashboard');
        }

        if ((int) $user->is_franchise === 1) {
            return redirect()->route('franchise.dashboard');
        }

        if ($user->isContributorStaff()) {
            return self::contributorDashboard($user);
        }

        return redirect()->route('student.dashboard');
    }

    public static function contributorDashboard(User $user): RedirectResponse
    {
        $roleIds = $user->contributorRoleIds();

        if ($roleIds === []) {
            return redirect()->route('management_login')
                ->with('error', 'No contributor role assigned to your account.');
        }

        if (empty(array_diff($roleIds, [6])) || count($roleIds) >= 2) {
            return redirect()->route('franchise.management.manager.dashboard');
        }

        if (empty(array_diff($roleIds, [7]))) {
            return redirect()->route('franchise.management.publisher.dashboard');
        }

        if (empty(array_diff($roleIds, [8]))) {
            return redirect()->route('franchise.management.creater.dashboard');
        }

        return redirect()->route('management_login')
            ->with('error', 'Your contributor role is not configured for dashboard access.');
    }
}
