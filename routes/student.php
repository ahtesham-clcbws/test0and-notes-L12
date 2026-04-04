<?php

use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ExamsController;
use App\Livewire\Student\Exams\Index as ExamsIndex;
use App\Http\Middleware\IsStudent;
use App\Http\Middleware\IsStudentGuest;
use App\Livewire\Student\Dashboard;
use App\Http\Controllers\Student\StudentPlanController;
use App\Http\Controllers\StudymaterialController;
use Illuminate\Support\Facades\Route;

Route::name('student.')->group(function () {
    Route::prefix('student')->group(function () {
        // Route::any('/login', [AuthController::class, 'studentlogin'])->middleware(['studentguest'])->name('login');
        Route::any('/password-reset/{code}', [AuthController::class, 'studentPasswordReset'])->middleware([IsStudentGuest::class])->name('password_reset');
        // Route::any('/forget-password', [AuthController::class, 'forgetPassword'])->middleware(['studentguest'])->name('forget_password');
        Route::middleware([IsStudent::class])->group(function () {
            Route::get('/', Dashboard::class)->name('dashboard');
            Route::any('/package_manage/{id}', [ExamsController::class, 'package_manage'])->name('package_manage');
            Route::get('attempt', \App\Livewire\Student\Exams\Attempted::class)->name('test-attempt');
            // Route::any('/profile', [DashboardController::class, 'profile'])->name('profile');
            Route::get('/verifynumber/{mobile_number}', [DashboardController::class, 'verifynumber'])->name('verifynumber');
            Route::get('/verifyotp/{mobile_number}/{mobile_otp}', [DashboardController::class, 'verifyotp'])->name('verifyotp');
            Route::get('/verifyemail/{email}', [DashboardController::class, 'verifyemail'])->name('verifyemail');
            Route::get('/verifyemailotp/{email}/{otp}', [DashboardController::class, 'verifyemailotp'])->name('verifyemailotp');
            // Route::post('/manage_profile_process', [DashboardController::class, 'manage_profile_process'])->name('manage_profile_process');

            Route::prefix('test')->group(function () {
                // Main Test Hub Redirect
                Route::get('', function() { return redirect()->route('student.dashboard_tests_list'); });

                // Institute tests (Coaching specific - the 2 tests you expect)
                Route::get('institute-tests/{cat?}', ExamsIndex::class)->name('institute_tests');

                // Practice tests (Global - the 6+ tests)
                Route::get('practice-tests/{cat?}', ExamsIndex::class)->name('dashboard_tests_list');
                Route::get('gyanology/{cat?}', ExamsIndex::class)->name('dashboard_gyanology_list');

                // Auxiliary routes
                Route::get('details/{name}', [ExamsController::class, 'getTest'])->name('test-name');
                Route::get('start-test/{testId}', \App\Livewire\Student\Tests\OnlineTestRunner::class)->name('start-test');
                // Route::get('conduct-test/{testId}', \App\Livewire\Student\Tests\OnlineTestRunner::class)->name('conduct-test');
                Route::get('question-paper/{test_id}', [ExamsController::class, 'questionPaper'])->name('question-paper');
                Route::get('show-result/{student_id}/{test_id}', \App\Livewire\Student\Tests\ShowResult::class)->name('show-result');
                // Route::get('attempt/{student_id}/{test_id}', [ExamsController::class, 'testAttempt'])->name('test-attempt');

                Route::prefix('section')->group(function () {
                    Route::any('question/{test_id}/{section_id}', [ExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                    Route::any('questionadd/{test_id}/{section_id}', [ExamsController::class, 'section_question_add'])->name('test_section_question_add');
                    Route::any('{test_id}/add-update', [ExamsController::class, 'testSections'])->name('dashboard_test_sections');
                    Route::any('{test_id}', [ExamsController::class, 'section'])->name('dashboard_test_section');
                });
            });

            Route::prefix('plan')->group(function () {
                Route::get('', \App\Livewire\Student\Packages\Index::class)->name('plan');
                Route::get('purchased', \App\Livewire\Student\Packages\Purchased::class)->name('my-plan');
                Route::post('checkout', [StudentPlanController::class, 'finalCheckout'])->name('package-checkout');
                Route::any('checkout/{id}', [StudentPlanController::class, 'checkout'])->name('plan-checkout');
                Route::get('payment-success', [StudentPlanController::class, 'paymentSuccess'])->name('payment-success');
                Route::get('payment-failed', [StudentPlanController::class, 'paymentFail'])->name('payment-failed');
            });

            Route::prefix('material')->group(function () {
                Route::get('notes-and-e-books', \App\Livewire\Student\Material\Index::class)->name('show');
                Route::get('live-classes', \App\Livewire\Student\Material\Index::class)->name('showvideo');
                Route::get('current-affairs', \App\Livewire\Student\Material\Index::class)->name('showgk');
                Route::get('comprehensive-notes', \App\Livewire\Student\Material\Index::class)->name('showComprehensive');
                Route::get('short-notes', \App\Livewire\Student\Material\Index::class)->name('showShortNotes');
                Route::get('premium-notes', \App\Livewire\Student\Material\Index::class)->name('showPremium');

                Route::any('download/{file}', [StudymaterialController::class, 'download'])->name('download');
                Route::any('viewmaterial/{file}', [StudymaterialController::class, 'viewMaterial'])->name('viewmaterial');
            });

            Route::prefix('feedback')->group(function () {
                Route::get('', [App\Http\Controllers\Student\ReviewController::class, 'index'])->name('review.index');
                Route::post('store', [App\Http\Controllers\Student\ReviewController::class, 'store'])->name('review.store');
            });

        });
        Route::get('profile', \App\Livewire\Student\Profile\Index::class)->name('profile');
        Route::prefix('settings')->group(function () {
            Route::any('dashboard', [SettingsController::class, 'dashboardSettings'])->name('dashboard_settings');
        });
    });
});
