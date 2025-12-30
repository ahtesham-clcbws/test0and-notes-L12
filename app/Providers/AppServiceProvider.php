<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\{ClassGoupExamModel};
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        // superadmin only
        Gate::define('superadmin', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'superadmin' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        // staffs only
        Gate::define('creator', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'creator' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('publisher', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'publisher' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('manager', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'manager' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('verifier', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'verifier' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('reviewer', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'reviewer' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        // direct student
        Gate::define('student', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'student' && !$user->isAdminAllowed && !$user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        // franchise only
        Gate::define('franchise', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise' && $user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        // franchise_staff only
        Gate::define('franchise_creator', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_creator' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('franchise_publisher', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_publisher' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('franchise_manager', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_manager' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('franchise_verifier', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_verifier' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('franchise_reviewer', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_reviewer' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
        // franchise student
        Gate::define('franchise_student', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_student' && $user->is_franchise) {
                    return true;
                }
            }
            return false;
        });
    }
}
