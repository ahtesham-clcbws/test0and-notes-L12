<?php

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\PlanController;

use App\Http\Controllers\InternalRequests\InternalRequestsController;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Key');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::any('/login2', [APIController::class, 'login']);
// Route::any('/register1', [APIController::class, 'register']);
Route::any('/verify_token', [APIController::class, 'verify_token']);
Route::get('/states', [InternalRequestsController::class, 'getStates']);
Route::post('studentLogin', [ApiController::class, 'studentLogin']);
Route::post('verifyBranchCode', [ApiController::class, 'verifyBranchCode']);
Route::post('verifyOTP', [ApiController::class, 'verifyOTP']);
Route::post('getOTP', [ApiController::class, 'getOTP']);
Route::post('verifyMobile', [ApiController::class, 'verifyMobile']);
Route::post('uniqueEmailCheck', [ApiController::class, 'uniqueEmailCheck']);
Route::post('studentSignup', [ApiController::class, 'studentSignup']);
Route::get('geteducationtype', [ApiController::class, 'geteducationtype']);
Route::get('getclassbyeducation', [ApiController::class, 'getclassbyeducation']);
Route::get('getstudymaterial', [ApiController::class, 'studymaterial']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('userdetails', [ApiController::class, 'userDetails']);
    Route::get('institutetest', [ApiController::class, 'instituteTest']);
    Route::get('gyanologytest', [ApiController::class, 'gyanologyTest']);
    Route::post('startgyanologytest', [ApiController::class, 'startGyanologyTest']);
    Route::post('attempttedtest', [ApiController::class, 'attempttedTest']);
    Route::post('endtest', [ApiController::class, 'endTest']);

    Route::get('logout', [ApiController::class, 'logout']);
});

