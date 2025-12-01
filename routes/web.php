<?php

use App\Http\Controllers\Frontend\FormsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InternalRequests\InternalRequestsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\CourseController;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\TestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});
Route::get('/', [HomeController::class, 'index'])->name('home_page');
Route::get('page', [HomeController::class, 'page'])->name('page');
Route::post('/', [InternalRequestsController::class, 'index']);
Route::get('demoemail', [InternalRequestsController::class, 'demoemail']);
Route::any('corporate-enquiry', [FormsController::class, 'businessEnquiry'])->name('bussines_enquiry');
Route::any('contributor', [FormsController::class, 'instituteUser'])->name('contributor');
Route::any('institute-signup', [FormsController::class, 'instituteSignup'])->name('institute_signup');
Route::any('reset-password/{studentid}/{resetid}', [FormsController::class, 'studentPasswordReset'])->name('student_recover_password');
Route::get('start-test', [HomeController::class, 'startTest'])->name('start_test');
Route::get('about', [HomeController::class, 'aboutUs'])->name('about_us');
Route::any('contact', [HomeController::class, 'contactUs'])->name('contact_us');
Route::get('plans', [HomeController::class, 'subscribePlan'])->name('plans');

//----------------------Test--------------------//
Route::get('test', [TestController::class, 'onlineTest'])->name('online_test');
Route::get('test/{name}', [TestController::class, 'getTest'])->name('test-name');
Route::get('start-test/{name}', [TestController::class, 'startTest'])->name('start-test');
Route::post('end-test/{name}', [TestController::class, 'endTest'])->name('end-test');
Route::get('show-result/{name}/{test_id}', [TestController::class, 'showResult'])->name('showResult');
Route::get('show-test-response/{name}/{test_id}', [TestController::class, 'showTestResponse'])->name('showTestResponse');
// Route::get('question-paper', [HomeController::class,'questionPaper'])->name('question_paper');
Route::get('question-paper/{name}', [TestController::class, 'questionPaper'])->name('question_paper');

//----------------------Class details--------------------//
Route::get('course/{edu_type}/{class}', [CourseController::class, 'index'])->name('course.index');

Route::any('logout', [SessionsController::class, 'destroy'])->name('logout');

// Route::get('payments/razorpay/checkout', 'App\Http\Controllers\Api\RazorpayController@checkout');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->to('/');
});

Route::redirect('admin', 'administrator', 301);

Route::view('resetpassword', 'Dashboard/Admin/reset_password');
Route::view('resetpassword_student', 'Dashboard/Student/reset_password');
Route::view('resetpassword_franchise', 'Dashboard/Franchise/reset_password');
Route::view('resetpassword_creater', 'Dashboard/Franchise/Management/Creater/reset_password');
Route::view('resetpassword_publisher', 'Dashboard/Franchise/Management/Publisher/reset_password');

Route::post('resetpassword', [AuthController::class, 'resetPwd']);
