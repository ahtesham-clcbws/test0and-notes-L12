<?php

use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ExamsController;
use App\Http\Middleware\IsStudent;
use App\Http\Middleware\IsStudentGuest;
use App\Http\Controllers\Student\StudentPlanController;
use App\Http\Controllers\StudymaterialController;
use Illuminate\Support\Facades\Route;

Route::name('student.')->group(function () {
    Route::prefix('student')->group(function () {
        Route::any('/password-reset/{code}', [AuthController::class, 'studentPasswordReset'])->middleware([IsStudentGuest::class])->name('password_reset');
        
        Route::middleware([IsStudent::class])->group(function () {
            // Reverted to Controller
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            
            Route::any('/package_manage/{id}', [ExamsController::class, 'package_manage'])->name('package_manage');
            Route::any('attempt', [ExamsController::class, 'testAttempt'])->name('test-attempt');
            Route::any('/profile', [DashboardController::class, 'profile'])->name('profile');
            Route::get('/verifynumber/{mobile_number}', [DashboardController::class, 'verifynumber'])->name('verifynumber');
            Route::get('/verifyotp/{mobile_number}/{mobile_otp}', [DashboardController::class, 'verifyotp'])->name('verifyotp');
            Route::get('/verifyemail/{email}', [DashboardController::class, 'verifyemail'])->name('verifyemail');
            Route::get('/verifyemailotp/{email}/{otp}', [DashboardController::class, 'verifyemailotp'])->name('verifyemailotp');
            Route::post('/manage_profile_process', [DashboardController::class, 'manage_profile_process'])->name('manage_profile_process');

            Route::prefix('test')->group(function () {
                // Reverted to Controller
                Route::get('', [ExamsController::class, 'index'])->name('dashboard_tests_list');
                Route::get('dashboard_gyanology_list/{cat?}', [ExamsController::class, 'index'])->name('dashboard_gyanology_list');
                
                Route::get('{name}', [ExamsController::class, 'getTest'])->name('test-name');
                
                // Reverted to Controller
                Route::get('start-test/{testId}', [ExamsController::class, 'startTest'])->name('start-test');
                
                Route::get('question-paper/{test_id}', [ExamsController::class, 'questionPaper'])->name('question-paper');
                
                // Reverted to Controller
                Route::get('show-result/{student_id}/{test_id}', [ExamsController::class, 'showResult'])->name('show-result');

                Route::prefix('section')->group(function () {
                    Route::any('question/{test_id}/{section_id}', [ExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                    Route::any('questionadd/{test_id}/{section_id}', [ExamsController::class, 'section_question_add'])->name('test_section_question_add');
                    Route::any('{test_id}/add-update', [ExamsController::class, 'testSections'])->name('dashboard_test_sections');
                    Route::any('{test_id}', [ExamsController::class, 'section'])->name('dashboard_test_section');
                });
            });

            Route::prefix('plan')->group(function () {
                Route::any('', [StudentPlanController::class, 'index'])->name('plan');
                Route::any('purchased', [StudentPlanController::class, 'myPlan'])->name('my-plan');
                Route::post('checkout', [StudentPlanController::class, 'finalCheckout'])->name('package-checkout');
                Route::any('checkout/{id}', [StudentPlanController::class, 'checkout'])->name('plan-checkout');
                Route::get('payment-success', [StudentPlanController::class, 'paymentSuccess'])->name('payment-success');
                Route::get('payment-failed', [StudentPlanController::class, 'paymentFail'])->name('payment-failed');
            });

            Route::prefix('material')->group(function () {
                Route::any('show', [StudymaterialController::class, 'show'])->name('show');
                Route::any('showvideo', [StudymaterialController::class, 'showvideo'])->name('showvideo');
                Route::any('showgk', [StudymaterialController::class, 'showgk'])->name('showgk');
                Route::any('showComprehensive', [StudymaterialController::class, 'showComprehensive'])->name('showComprehensive');
                Route::any('showShortNotes', [StudymaterialController::class, 'showShortNotes'])->name('showShortNotes');
                Route::any('showPremium', [StudymaterialController::class, 'showPremium'])->name('showPremium');

                Route::any('download/{file}', [StudymaterialController::class, 'download'])->name('download');
                Route::any('viewmaterial/{file}', [StudymaterialController::class, 'viewMaterial'])->name('viewmaterial');
            });

            Route::prefix('feedback')->group(function () {
                Route::get('', [App\Http\Controllers\Student\ReviewController::class, 'index'])->name('review.index');
                Route::post('store', [App\Http\Controllers\Student\ReviewController::class, 'store'])->name('review.store');
            });

        });
        Route::prefix('settings')->group(function () {
            Route::any('dashboard', [SettingsController::class, 'dashboardSettings'])->name('dashboard_settings');
        });
    });
});
