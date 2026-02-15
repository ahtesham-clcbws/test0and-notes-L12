<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\CorporateEnquiry;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamsController;
use App\Http\Controllers\Admin\FranchiseController;
use App\Http\Controllers\Admin\QuestionBankController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\StudymaterialController;

use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\AuthController;
use App\Livewire\Admin\Contact\ContactList;
use App\Livewire\Admin\Contact\ContactListReply;
use App\Livewire\Admin\Contact\ContactRepliesList;
use App\Livewire\Admin\Pages\PagesList;
use App\Livewire\Admin\ManageFaq;
use App\Livewire\Admin\ManageImportantLinks;
use App\Livewire\Admin\Pages\PagesView;

//Raj@KNP78  careerwithoutbarrier@gmail.com
Route::post('gettestpackage', [ExamsController::class, 'gettestpackage'])->name('gettestpackage');

Route::name('administrator.')->group(function () {
    Route::prefix('administrator')->group(function () {
        Route::any('/login', [AuthController::class, 'adminlogin'])->middleware(['adminguest'])->name('login');
        Route::any('/password-reset/{email}/{code}', [AuthController::class, 'adminPasswordReset'])->middleware(['adminguest'])->name('password_reset');
        // Route::any('/forget-password', [AuthController::class, 'forgetPassword'])->middleware(['adminguest'])->name('forget_password');
        Route::middleware(['is_admin'])->group(function () {
            Route::any('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::prefix('corporate-enquiry')->group(function () {
                Route::any('', [CorporateEnquiry::class, 'index'])->name('corporate_enquiry');
                Route::any('type/{type}', [CorporateEnquiry::class, 'index'])->name('corporate_enquiry_type');
                Route::any('view/{id}', [CorporateEnquiry::class, 'show'])->name('corporate_enquiry_show');
                Route::any('delete/{id}', [CorporateEnquiry::class, 'delete'])->name('corporate_enquiry_delete');
            });
            Route::get('course-detail-master', [DashboardController::class, 'courseDetail'])->name('course-detail-add');
            Route::get('course-detail-list', [DashboardController::class, 'courseMasterList'])->name('course-detail-list');
            Route::get('course-detail-edit/{id}', [DashboardController::class, 'courseDetailEdit'])->name('course-detail-edit');
            Route::post('course-detail-store', [DashboardController::class, 'courseDetailStore'])->name('course-detail-store');
            Route::post('course-detail-update/{id}', [DashboardController::class, 'courseDetailUpdate'])->name('course-detail-update');

            Route::prefix('franchise')->group(function () {
                Route::any('', [FranchiseController::class, 'index'])->name('franchise_all');
                Route::any('status/{status}', [FranchiseController::class, 'index'])->name('franchise_by_status');
                Route::any('type/{type}', [FranchiseController::class, 'byType'])->name('franchise_type');
                Route::any('view/type/{type}', [FranchiseController::class, 'franchise'])->name('admin_franchise_view');
                Route::any('view/{id}', [FranchiseController::class, 'show'])->name('franchise_view');
                Route::any('delete/{id}', [FranchiseController::class, 'delete'])->name('franchise_delete');
                Route::any('viewusers/{id}', [FranchiseController::class, 'viewusers'])->name('franchise_viewusers');
                Route::any('viewstudentusers/{id}', [FranchiseController::class, 'viewstudentusers'])->name('franchise_viewstudentusers');
                Route::any('viewmaterial/{id}', [FranchiseController::class, 'viewmaterial'])->name('franchise_viewmaterial');
                // Route::any('franchise/{status}', [FranchiseController::class, 'index'])->name('franchise_by_status');
            });

            Route::prefix('users')->group(function () {
                Route::any('add', [UsersController::class, 'add'])->name('add_user');
                Route::any('type/{type}/{franchise:?}', [UsersController::class, 'index'])->name('admin_users_list');
                Route::any('view/{id}', [UsersController::class, 'show'])->name('user_show');
                Route::any('delete/{id}', [UsersController::class, 'delete'])->name('user_delete');
            });
            Route::prefix('plan')->group(function () {
                Route::any('', [PlanController::class, 'index'])->name('plan');
                Route::any('is_featured/{plan_id}/{status}', [PlanController::class, 'is_featured']);
                Route::any('add', [PlanController::class, 'addPlan'])->name('plan_add');
                Route::any('add/{id}', [PlanController::class, 'addPlan'])->name('plan_view');
                // Route::any('delete/{id}', [PlanController::class, 'delete'])->name('plan_delete');
                Route::post('deletedata', [PlanController::class, 'destroy'])->name('plan_delete');
            });
            Route::prefix('material')->group(function () {
                Route::any('', [StudymaterialController::class, 'adminIndex'])->name('material');
                Route::get('getpackage/{education_type_id}/{class_group_exam_id}/{value}', [StudymaterialController::class, 'getpackage'])->name('getpackage');
                Route::any('add', [StudymaterialController::class, 'create'])->name('material_add');
                Route::any('store', [StudymaterialController::class, 'store'])->name('store');
                Route::any('is_featured/{plan_id}/{status}', [StudymaterialController::class, 'is_featured']);
                Route::any('download/{file}', [StudymaterialController::class, 'download'])->name('download');
                Route::any('add/{id}', [StudymaterialController::class, 'edit'])->name('edit');
                Route::post('deletedata', [StudymaterialController::class, 'destroy'])->name('material_delete');
                Route::post('pausematerial', [StudymaterialController::class, 'pauseMaterial'])->name('material_pause');
                Route::post('sendbackmaterial', [StudymaterialController::class, 'sendbackMaterial'])->name('material_sendback');
            });
            Route::prefix('books')->group(function () {
                Route::any('', [BooksController::class, 'index'])->name('books');
                Route::any('add', [BooksController::class, 'save'])->name('book_add');
                Route::any('view/{id}', [BooksController::class, 'view'])->name('book_view');
                Route::any('delete/{id}', [BooksController::class, 'delete'])->name('book_delete');
            });
            Route::prefix('ajax')->group(function () {
                Route::post('franchise-request', [AjaxController::class, 'franchiseRequest']);
            });
            Route::prefix('test')->group(function () {
                Route::any('', [ExamsController::class, 'index'])->name('dashboard_tests_list');
                Route::any('category/list', [ExamsController::class, 'test_category'])->name('dashboard_add_test_category');
                Route::any('category/add', [ExamsController::class, 'manage_test_category'])->name('add_category');
                Route::any('category/edit/{id}', [ExamsController::class, 'manage_test_category'])->name('edit_category');
                Route::any('category/delete/{id}', [ExamsController::class, 'delete_category'])->name('delete_category');
                Route::any('category/process', [ExamsController::class, 'manage_test_cat_process'])->name('manage_test_cat_process');
                Route::any('add', [ExamsController::class, 'saveTest'])->name('dashboard_add_exams');
                Route::get('feature/{id}', [ExamsController::class, 'test_feature_update'])->name('test_feature_update');

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
                Route::any('eductaion-type', [ExamsController::class, 'eductaion_type'])->name('dashboard_eductaion_type');
                Route::any('subjects', [ExamsController::class, 'subjects'])->name('dashboard_subjects');
            });
            Route::prefix('questions-bank')->group(function () {
                Route::any('list/{type?}', [QuestionBankController::class, 'index'])->name('dashboard_question_list');
                Route::any('show/{id}', [QuestionBankController::class, 'show'])->name('dashboard_question_show');
                Route::any('add', [QuestionBankController::class, 'add_update'])->name('dashboard_question_add');
                Route::any('import', [QuestionBankController::class, 'importView'])->name('dashboard_question_import');
                Route::post('import', [QuestionBankController::class, 'import'])->name('dashboard_question_import_store');
                Route::any('update/{id}', [QuestionBankController::class, 'add_update'])->name('dashboard_question_update');
            });
            Route::prefix('profile')->group(function () {
                Route::any('', [UsersController::class, 'myPofile'])->name('admin_panel_profile');
            });
            Route::prefix('settings')->group(function () {
                Route::any('dashboard', [SettingsController::class, 'dashboardSettings'])->name('dashboard_settings');
                Route::any('no-otp-numbers', [SettingsController::class, 'noOtpNumbers'])->name('dashboard_default_numbers');
                Route::any('delete-number', [SettingsController::class, 'delete_number'])->name('dashboard_default_number_delete');
                Route::any('manage_home', [SettingsController::class, 'manage_home'])->name('manage_home');
                Route::post('manage_home_process', [SettingsController::class, 'manage_home_process'])->name('manage_home_process');
                Route::get('slider_delete/{image}', [SettingsController::class, 'slider_delete'])->name('slider_delete');
                Route::post('update_slider_url', [SettingsController::class, 'update_slider_url'])->name('update_slider_url');
                Route::post('upload_partner_logos', [SettingsController::class, 'upload_partner_logos'])->name('upload_partner_logos');
                Route::any('pdf-list', [SettingsController::class, 'pdfList'])->name('dashboard_add_pdf_content');
                Route::post('pdf-submit', [SettingsController::class, 'pdfSubmit'])->name('pdf_submit');
                Route::post('pdf-delete', [SettingsController::class, 'pdfDelete'])->name('pdf_delete');
                // livewire
                Route::any('pages', PagesList::class)->name('website_pages');
                Route::any('pages/{page}/update', PagesView::class)->name('website_pages.update');

                Route::any('faq', ManageFaq::class)->name('manage.faq');
                Route::any('important-links', ManageImportantLinks::class)->name('manage.important_links');


                Route::get('/contact_enquiry', ContactList::class)->name('manage.contactEnquiry');
                Route::get('/contact_enquiry/{id}', ContactListReply::class)->name('manage.contactEnquiryReply');
                Route::get('/contact-replies/{id}', ContactRepliesList::class)->name('manage.contactRelpiesList');

                Route::any('reviews', \App\Livewire\Admin\ManageReviews::class)->name('manage.reviews');
            });
        });
    });
});
