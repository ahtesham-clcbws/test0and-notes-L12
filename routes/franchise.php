<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\FormsController;
use App\Http\Controllers\Frontend\Franchise\DashboardController;
use App\Http\Controllers\Frontend\Franchise\ExamsController;
use App\Http\Controllers\Frontend\Franchise\UserController;
use App\Http\Controllers\StudymaterialController;

use App\Http\Controllers\Frontend\Franchise\Management\DashboardController as ManagementDashboardController;
use App\Http\Controllers\Frontend\Franchise\Management\ExamsController as ManagementExamsController;

use App\Http\Controllers\Frontend\Franchise\Management\Creater\DashboardController as CreaterDashboardController;
use App\Http\Controllers\Frontend\Franchise\Management\Creater\ExamsController as CreaterExamsController;

use App\Http\Controllers\Frontend\Franchise\Management\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Frontend\Franchise\Management\Manager\ExamsController as ManagerExamsController;

use App\Http\Controllers\Frontend\Franchise\Management\Publisher\DashboardController as PublisherDashboardController;
use App\Http\Controllers\Frontend\Franchise\Management\Publisher\ExamsController as PublisherExamsController;
use App\Http\Middleware\IsFranchise;
use App\Livewire\Frontend\Auth\ContributorSignUp;

// Route::any('contributor-signup', [FormsController::class, 'instituteUser'])->name('contributor');
Route::any('contributor-signup', ContributorSignUp::class)->name('contributor');
Route::any('/contributor-login', [AuthController::class, 'franchiseManagementLogin'])->middleware(['managementguest'])->name('management_login');

Route::name('franchise.')->group(function () {
    Route::any('corporate-login', [AuthController::class, 'franchiselogin'])->middleware(['franchiseguest'])->name('login');
    Route::prefix('corporate')->group(function () {

        // Route::any('/forget-password', [AuthController::class, 'forgetPassword'])->middleware(['franchiseguest'])->name('forget_password');
        Route::any('/password-reset/{email}/{code}', [AuthController::class, 'franchisePasswordReset'])->middleware(['franchiseguest'])->name('password_reset');
        // Route::any('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::name('management.')->group(function () {
            Route::prefix('management')->group(function () {
                Route::name('creater.')->group(function () {
                    Route::prefix('creater')->group(function () {
                        Route::middleware('is_creater')->group(function () {
                            Route::any('/', [CreaterDashboardController::class, 'index'])->name('dashboard');

                            Route::prefix('test')->group(function () {
                                Route::any('', [CreaterExamsController::class, 'index'])->name('dashboard_tests_list');
                                // Route::any('add', [CreaterExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                                Route::any('update/{test_id}', [CreaterExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                                Route::any('publish/{test_id}', [CreaterExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                                Route::prefix('section')->group(function () {
                                    Route::any('question/{test_id}/{section_id}', [CreaterExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                                    Route::any('questionadd/{test_id}/{section_id}', [CreaterExamsController::class, 'section_question_add'])->name('test_section_question_add');
                                    Route::any('{test_id}/add-update', [CreaterExamsController::class, 'testSections'])->name('dashboard_test_sections');
                                    Route::any('{test_id}', [CreaterExamsController::class, 'section'])->name('dashboard_test_section');
                                });
                            });

                            Route::prefix('material')->group(function () {
                                Route::any('', [StudymaterialController::class, 'index'])->name('material');
                                Route::any('add', [StudymaterialController::class, 'create'])->name('material_add');
                                Route::any('store', [StudymaterialController::class, 'store'])->name('store');
                                Route::any('download/{file}', [StudymaterialController::class, 'download'])->name('download');
                                Route::any('add/{id}', [StudymaterialController::class, 'edit'])->name('edit');
                                Route::post('deletedata', [StudymaterialController::class, 'destroy'])->name('material_delete');
                                Route::post('pausematerial', [StudymaterialController::class, 'pauseMaterial'])->name('material_pause');
                            });
                        });
                    });
                });

                Route::prefix('profile')->group(function () {
                    Route::any('', [UserController::class, 'myProfile'])->name('panel_profile');
                    // Route::any('', [UserController::class,'myProfile_creater_publisher'])->name('panelprofile');
                });

                Route::name('publisher.')->group(function () {
                    Route::prefix('publisher')->group(function () {
                        Route::middleware('is_publisher')->group(function () {
                            Route::any('/', [PublisherDashboardController::class, 'index'])->name('dashboard');

                            Route::prefix('test')->group(function () {
                                Route::any('', [PublisherExamsController::class, 'index'])->name('dashboard_tests_list');
                                // Route::any('add', [PublisherExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                                Route::any('update/{test_id}', [PublisherExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                                Route::any('publish/{test_id}', [PublisherExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                                Route::prefix('section')->group(function () {
                                    Route::any('question/{test_id}/{section_id}', [PublisherExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                                    Route::any('questionadd/{test_id}/{section_id}', [PublisherExamsController::class, 'section_question_add'])->name('test_section_question_add');
                                    Route::any('{test_id}/add-update', [PublisherExamsController::class, 'testSections'])->name('dashboard_test_sections');
                                    Route::any('{test_id}', [PublisherExamsController::class, 'section'])->name('dashboard_test_section');
                                });
                            });
                            Route::prefix('material')->group(function () {
                                Route::any('', [StudymaterialController::class, 'index'])->name('material');
                                Route::any('add', [StudymaterialController::class, 'create'])->name('material_add');
                                Route::any('store', [StudymaterialController::class, 'store'])->name('store');
                                Route::any('download/{file}', [StudymaterialController::class, 'download'])->name('download');
                                Route::any('add/{id}', [StudymaterialController::class, 'edit'])->name('edit');
                                Route::post('deletedata', [StudymaterialController::class, 'destroy'])->name('material_delete');
                                Route::post('pausematerial', [StudymaterialController::class, 'pauseMaterial'])->name('material_pause');
                            });
                        });
                    });
                });

                Route::name('manager.')->group(function () {
                    Route::prefix('manager')->group(function () {
                        Route::middleware('is_manager')->group(function () {
                            Route::any('/', [ManagerDashboardController::class, 'index'])->name('dashboard');
                            Route::prefix('test')->group(function () {
                                Route::any('', [ManagerExamsController::class, 'index'])->name('dashboard_tests_list');
                                Route::any('add', [ManagerExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                                Route::any('update/{test_id}', [ManagerExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                                Route::any('publish/{test_id}', [ManagerExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                                Route::prefix('section')->group(function () {
                                    Route::any('question/{test_id}/{section_id}', [ManagerExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                                    Route::any('questionadd/{test_id}/{section_id}', [ManagerExamsController::class, 'section_question_add'])->name('test_section_question_add');
                                    Route::any('{test_id}/add-update', [ManagerExamsController::class, 'testSections'])->name('dashboard_test_sections');
                                    Route::any('{test_id}', [ManagerExamsController::class, 'section'])->name('dashboard_test_section');
                                });
                            });
                        });
                    });
                });

                Route::prefix('material')->group(function () {
                    Route::any('', [StudymaterialController::class, 'index'])->name('material');
                    Route::any('add', [StudymaterialController::class, 'create'])->name('material_add');
                    Route::any('store', [StudymaterialController::class, 'store'])->name('store');
                    Route::any('download/{file}', [StudymaterialController::class, 'download'])->name('download');
                    Route::any('add/{id}', [StudymaterialController::class, 'edit'])->name('edit');
                    Route::post('deletedata', [StudymaterialController::class, 'destroy'])->name('material_delete');
                    Route::post('pausematerial', [StudymaterialController::class, 'pauseMaterial'])->name('material_pause');
                    Route::post('sendbackmaterial', [StudymaterialController::class, 'sendbackMaterial'])->name('material_sendback');
                });

                Route::middleware('is_management')->group(function () {
                    Route::any('/', [ManagementDashboardController::class, 'index'])->name('dashboard');

                    //     Route::prefix('test')->group(function () {
                    //         Route::any('', [ManagementExamsController::class, 'index'])->name('dashboard_tests_list');
                    //         Route::any('add', [ManagementExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                    //         Route::any('update/{test_id}', [ManagementExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                    //         Route::any('publish/{test_id}', [ManagementExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                    //         Route::prefix('section')->group(function () {
                    //             Route::any('question/{test_id}/{section_id}', [ManagementExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                    //             Route::any('questionadd/{test_id}/{section_id}', [ManagementExamsController::class, 'section_question_add'])->name('test_section_question_add');
                    //             Route::any('{test_id}/add-update', [ManagementExamsController::class, 'testSections'])->name('dashboard_test_sections');
                    //             Route::any('{test_id}', [ManagementExamsController::class, 'section'])->name('dashboard_test_section');
                    //         });
                    //     });

                    // Route::name('creater.')->group(function(){
                    //     Route::prefix('creater')->group(function(){
                    //         Route::middleware('is_creater')->group(function(){
                    //             Route::prefix('test')->group(function () {
                    //                 Route::any('', [ManagementExamsController::class, 'index'])->name('dashboard_tests_list');
                    //                 Route::any('add', [ManagementExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                    //                 Route::any('update/{test_id}', [ManagementExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                    //                 Route::any('publish/{test_id}', [ManagementExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                    //                 Route::prefix('section')->group(function () {
                    //                     Route::any('question/{test_id}/{section_id}', [ManagementExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                    //                     Route::any('questionadd/{test_id}/{section_id}', [ManagementExamsController::class, 'section_question_add'])->name('test_section_question_add');
                    //                     Route::any('{test_id}/add-update', [ManagementExamsController::class, 'testSections'])->name('dashboard_test_sections');
                    //                     Route::any('{test_id}', [ManagementExamsController::class, 'section'])->name('dashboard_test_section');
                    //                 });
                    //             });
                    //         });
                    //     });
                    // });

                    // Route::name('publisher.')->group(function(){
                    //     Route::prefix('publisher')->group(function(){
                    //         Route::middleware('is_publisher')->group(function(){
                    //             Route::prefix('test')->group(function () {
                    //                 Route::any('', [ManagementExamsController::class, 'index'])->name('dashboard_tests_list');
                    //                 Route::any('add', [ManagementExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                    //                 Route::any('update/{test_id}', [ManagementExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                    //                 Route::any('publish/{test_id}', [ManagementExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                    //                 Route::prefix('section')->group(function () {
                    //                     Route::any('question/{test_id}/{section_id}', [ManagementExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                    //                     Route::any('questionadd/{test_id}/{section_id}', [ManagementExamsController::class, 'section_question_add'])->name('test_section_question_add');
                    //                     Route::any('{test_id}/add-update', [ManagementExamsController::class, 'testSections'])->name('dashboard_test_sections');
                    //                     Route::any('{test_id}', [ManagementExamsController::class, 'section'])->name('dashboard_test_section');
                    //                 });
                    //             });
                    //         });
                    //     });
                    // });

                    // Route::name('creater.')->group(function(){
                    //     Route::prefix('creater')->group(function(){
                    //         Route::middleware('is_creater')->group(function(){
                    //             Route::prefix('test')->group(function () {
                    //                 Route::any('', [ManagementExamsController::class, 'index'])->name('dashboard_tests_list');
                    //                 Route::any('add', [ManagementExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                    //                 Route::any('update/{test_id}', [ManagementExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                    //                 Route::any('publish/{test_id}', [ManagementExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                    //                 Route::prefix('section')->group(function () {
                    //                     Route::any('question/{test_id}/{section_id}', [ManagementExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                    //                     Route::any('questionadd/{test_id}/{section_id}', [ManagementExamsController::class, 'section_question_add'])->name('test_section_question_add');
                    //                     Route::any('{test_id}/add-update', [ManagementExamsController::class, 'testSections'])->name('dashboard_test_sections');
                    //                     Route::any('{test_id}', [ManagementExamsController::class, 'section'])->name('dashboard_test_section');
                    //                 });
                    //             });
                    //         });
                    //     });
                    // });

                    // Route::name('creater.')->group(function(){
                    //     Route::prefix('creater')->group(function(){
                    //         Route::middleware('is_creater')->group(function(){

                    //         });
                    //     });
                    // });

                });
            });
        });

        Route::middleware(IsFranchise::class)->group(function () {
            Route::any('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::any('users', [UserController::class, 'index'])->name('users');
            Route::any('users/{type}', [UserController::class, 'index'])->name('users_type');
            Route::any('user/view/{id}', [UserController::class, 'show'])->name('user_show');
            Route::any('user/add', [UserController::class, 'addUser'])->name('add_user');
            Route::prefix('settings')->group(function () {
                Route::any('dashboard', [SettingsController::class, 'dashboardSettings'])->name('dashboard_settings');
            });
            Route::prefix('profile')->group(function () {
                Route::any('', [UserController::class, 'myProfile'])->name('panel_profile');
                // Route::any('', [UserController::class,'myProfile_creater_publisher'])->name('panelprofile');
            });

            Route::prefix('test')->group(function () {
                Route::any('', [ExamsController::class, 'index'])->name('dashboard_tests_list');
                Route::any('add', [ExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                Route::any('attempt', [ExamsController::class, 'attemptTest'])->name('dashboard_tests_attempt');
                Route::any('update/{test_id}', [ExamsController::class, 'saveTest'])->name('dashboard_update_test_exam');
                Route::any('publish/{test_id}', [ExamsController::class, 'publishTest'])->name('dashboard_publish_test_exam');
                Route::any('student-list/{test_id}', [ExamsController::class, 'studentList'])->name('dashboard_student_list');


                Route::prefix('section')->group(function () {
                    Route::any('question/{test_id}/{section_id}', [ExamsController::class, 'section_questions'])->name('dashboard_test_section_question');
                    Route::any('questionadd/{test_id}/{section_id}', [ExamsController::class, 'section_question_add'])->name('test_section_question_add');
                    Route::any('{test_id}/add-update', [ExamsController::class, 'testSections'])->name('dashboard_test_sections');
                    Route::any('{test_id}', [ExamsController::class, 'section'])->name('dashboard_test_section');
                });
            });
        });

    });
});
