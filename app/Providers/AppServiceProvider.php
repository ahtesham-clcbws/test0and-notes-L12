<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\Msg91Service::class, function ($app) {
            return new \App\Services\Msg91Service;
        });
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
                if ($role == 'superadmin' && $user->isAdminAllowed && $user->is_staff && ! $user->is_franchise) {
                    return true;
                }
            }

            return false;
        });
        // staffs only
        Gate::define('creator', fn (User $user) => $user->isDirectContributor() && $user->hasRoleName('creator'));
        Gate::define('publisher', fn (User $user) => $user->isDirectContributor() && $user->hasRoleName('publisher'));
        Gate::define('manager', fn (User $user) => $user->isDirectContributor() && $user->hasRoleName('manager'));
        Gate::define('verifier', fn (User $user) => $user->isDirectContributor() && $user->hasRoleName('verifier'));
        Gate::define('reviewer', fn (User $user) => $user->isDirectContributor() && $user->hasRoleName('reviewer'));
        // direct student
        Gate::define('student', function (User $user) {
            $roles = explode(',', $user->roles);
            foreach ($roles as $role) {
                if ($role == 'student' && ! $user->isAdminAllowed && ! $user->is_staff && ! $user->is_franchise) {
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
        Gate::define('franchise_creator', fn (User $user) => $user->isInstituteContributor() && $user->hasRoleName('creator'));
        Gate::define('franchise_publisher', fn (User $user) => $user->isInstituteContributor() && $user->hasRoleName('publisher'));
        Gate::define('franchise_manager', fn (User $user) => $user->isInstituteContributor() && $user->hasRoleName('manager'));
        Gate::define('franchise_verifier', fn (User $user) => $user->isInstituteContributor() && $user->hasRoleName('verifier'));
        Gate::define('franchise_reviewer', fn (User $user) => $user->isInstituteContributor() && $user->hasRoleName('reviewer'));
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

        // Register Observers
        \App\Models\Gn_PackagePlan::observe(\App\Observers\GnPackagePlanObserver::class);
        \App\Models\Studymaterial::observe(\App\Observers\StudymaterialObserver::class);
        \App\Models\Review::observe(\App\Observers\ReviewObserver::class);
        \App\Models\TestModal::observe(\App\Observers\TestObserver::class);
        \App\Models\TestSections::observe(\App\Observers\TestSectionObserver::class);
        \App\Models\TestQuestions::observe(\App\Observers\TestQuestionObserver::class);

        // View Composer for Student Sidebar
        View::composer('Dashboard.Student.partials.sidebar', function ($view) {
            $view->with('test_cat_sidebar', \App\Models\TestCat::get());
        });
    }
}
