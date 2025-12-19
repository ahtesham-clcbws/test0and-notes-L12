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
use App\Livewire\Frontend\Auth\ForgotPassword;
use App\Livewire\Frontend\Auth\Login;
use App\Livewire\Frontend\Auth\Register;
use App\Livewire\Frontend\ContactUsPage;
use App\Livewire\Frontend\Faq;
use App\Livewire\Frontend\ImportantLinksWebsitePage;
use App\Livewire\Frontend\Pages;

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

// Route::get('/clear', function () {
//     $exitCode = Artisan::call('cache:clear');
//     $exitCode = Artisan::call('config:cache');
//     return 'DONE'; //Return anything
// });
Route::get('/', [HomeController::class, 'index'])->name('home_page');
Route::get('page', [HomeController::class, 'page'])->name('page');
Route::post('/', [InternalRequestsController::class, 'index']);
Route::get('demoemail', [InternalRequestsController::class, 'demoemail']);
Route::any('corporate-enquiry', [FormsController::class, 'businessEnquiry'])->name('bussines_enquiry');
Route::any('contributor', [FormsController::class, 'instituteUser'])->name('contributor');
Route::any('institute-signup', [FormsController::class, 'instituteSignup'])->name('institute_signup');
Route::any('reset-password/{studentid}/{resetid}', [FormsController::class, 'studentPasswordReset'])->name('student_recover_password');
Route::get('start-test', [HomeController::class, 'startTest'])->name('start_test');
Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about_us');
Route::any('contact-us', ContactUsPage::class)->name('contact_us');
Route::get('plans', [HomeController::class, 'subscribePlan'])->name('plans');

Route::any('login', Login::class)->name('login');
Route::any('registration', Register::class)->name('register');
Route::any('forgot-password', ForgotPassword::class)->name('forgot_password');

Route::get('faq', Faq::class)->name('faqs');
Route::get('important-links', ImportantLinksWebsitePage::class)->name('important_links');

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

// Route::view('resetpassword', 'Dashboard/Admin/reset_password');
// Route::view('resetpassword_student', 'Dashboard/Student/reset_password');
// Route::view('resetpassword_franchise', 'Dashboard/Franchise/reset_password');
// Route::view('resetpassword_creater', 'Dashboard/Franchise/Management/Creater/reset_password');
// Route::view('resetpassword_publisher', 'Dashboard/Franchise/Management/Publisher/reset_password');

Route::post('resetpassword', [AuthController::class, 'resetPwd']);


Route::any('{slug}', Pages::class)->name('policy-page');
// Route::any('privacy-policy', Pages::class);
// Route::any('terms-and-conditions', Pages::class);
