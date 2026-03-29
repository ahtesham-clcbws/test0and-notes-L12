<?php

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\InternalRequests\InternalRequestsController;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Key');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the framework within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::any('/login2', [APIController::class, 'login']);
// Route::any('/register1', [APIController::class, 'register']);
Route::any('/verify_token', [APIController::class, 'verify_token']);
Route::get('/states', [InternalRequestsController::class, 'getStates']);
Route::get('/cities', [InternalRequestsController::class, 'getCities']);
Route::post('studentLogin', [ApiController::class, 'studentLogin']);
Route::post('verifyBranchCode', [ApiController::class, 'verifyBranchCode']);
Route::post('verifyOTP', [ApiController::class, 'verifyOTP']);
Route::post('getOTP', [ApiController::class, 'getOTP']);
Route::post('verifyMobile', [ApiController::class, 'verifyMobile']);
Route::post('uniqueEmailCheck', [ApiController::class, 'uniqueEmailCheck']);
Route::post('studentSignup', [ApiController::class, 'studentSignup']);
Route::get('geteducationtype', [ApiController::class, 'geteducationtype']);
Route::get('getclassbyeducation', [ApiController::class, 'getclassbyeducation']);
Route::get('getPremiumData', [APIController::class, 'getPremiumData']);
Route::any('/gethomepagedata', [APIController::class, 'getHomepageData']);
Route::post('forgotPassword', [ApiController::class, 'forgotPassword']);
Route::post('verifyOTP', [ApiController::class, 'verifyOTP']);
Route::post('resetPassword', [ApiController::class, 'resetPassword']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('getstudymaterial', [ApiController::class, 'studymaterial']);
    Route::get('userdetails', [ApiController::class, 'userDetails']);
    Route::post('updateProfile', [ApiController::class, 'updateProfile']);
    Route::get('institutetest', [ApiController::class, 'instituteTest']);
    Route::get('testAndNotesTest', [ApiController::class, 'testAndNotesTest']);
    Route::post('startTestAndNotesTest', [ApiController::class, 'startTestAndNotesTest']);
    Route::post('attempttedtest', [ApiController::class, 'attempttedTest']);
    Route::post('endtest', [ApiController::class, 'endTest']);

    Route::post('createRazorpayOrder', [ApiController::class, 'createRazorpayOrder']);
    Route::post('verifyRazorpayPayment', [ApiController::class, 'verifyRazorpayPayment']);
    Route::get('getTestResult', [ApiController::class, 'getTestResult']);
    Route::get('getTestResultWithSolution', [APIController::class, 'getTestResultWithSolution']);
    Route::get('getTests', [ApiController::class, 'getTests']);
    Route::get('getTestDetails', [ApiController::class, 'getTestDetails']);
    Route::get('getStudyMaterialDetails', [ApiController::class, 'getStudyMaterialDetails']);
    Route::get('getMyPackages', [ApiController::class, 'getMyPackages']);
    Route::get('getAttemptedTests', [ApiController::class, 'getAttemptedTests']);
    Route::get('logout', [ApiController::class, 'logout']);
});
