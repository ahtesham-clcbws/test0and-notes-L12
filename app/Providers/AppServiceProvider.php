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
        $classes = ClassGoupExamModel::where(['education_type_id' => 52])->get();
        $getGovt = ClassGoupExamModel::where(['education_type_id' => 53])->get();
        $getCompotition = ClassGoupExamModel::where(['education_type_id' => 51])->get();
        // dd($classes);
        View::share('classes', $classes);
        View::share('getGovt', $getGovt);
        View::share('getCompotition', $getCompotition);

        // superadmin only
        Gate::define('superadmin', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'superadmin' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('administrator.login');
        });
        // staffs only
        Gate::define('creator', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'creator' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('administrator.login');
        });
        Gate::define('publisher', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'publisher' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('administrator.login');
        });
        Gate::define('manager', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'manager' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('administrator.login');
        });
        Gate::define('verifier', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'verifier' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('administrator.login');
        });
        Gate::define('reviewer', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'reviewer' && $user->isAdminAllowed && $user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('administrator.login');
        });
        // direct student
        Gate::define('student', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'student' && !$user->isAdminAllowed && !$user->is_staff && !$user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('student.login');
        });
        // franchise only
        Gate::define('franchise', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise' && $user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('franchise.login');
        });
        // franchise_staff only
        Gate::define('franchise_creator', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_creator' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('franchise.login');
        });
        Gate::define('franchise_publisher', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_publisher' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('franchise.login');
        });
        Gate::define('franchise_manager', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_manager' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('franchise.login');
        });
        Gate::define('franchise_verifier', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_verifier' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('franchise.login');
        });
        Gate::define('franchise_reviewer', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_reviewer' && $user->is_staff && $user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('franchise.login');
        });
        // franchise student
        Gate::define('franchise_student', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'franchise_student' && $user->is_franchise) {
                    return true;
                }
            }
            return redirect()->route('student.login');
        });
    }
}
