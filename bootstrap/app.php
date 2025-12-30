<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/administrator.php'));

            Route::middleware('web')
                ->group(base_path('routes/franchise.php'));

            Route::middleware('web')
                ->group(base_path('routes/student.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin'          => \App\Http\Middleware\IsAdmin::class,
            'is_franchise'      => \App\Http\Middleware\IsFranchise::class,
            'is_student'        => \App\Http\Middleware\IsStudent::class,
            'is_management'     => \App\Http\Middleware\IsManagement::class,
            'is_creater'        => \App\Http\Middleware\Management\IsCreater::class,
            'is_publisher'      => \App\Http\Middleware\Management\IsPublisher::class,
            'is_manager'        => \App\Http\Middleware\Management\IsManager::class,
            'is_multi'          => \App\Http\Middleware\Management\IsMulti::class,
            'adminguest'        => \App\Http\Middleware\IsAdminGuest::class,
            'franchiseguest'    => \App\Http\Middleware\IsFranchiseGuest::class,
            'studentguest'      => \App\Http\Middleware\IsStudentGuest::class,
            'managementguest'   => \App\Http\Middleware\IsManagementGuest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
