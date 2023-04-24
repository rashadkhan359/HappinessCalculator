<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ContactusController;
use App\Http\Controllers\Api\HomeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Authentication APIs

Route::post('/sign-up', [AuthenticationController::class, 'signup'])->name('signup');
Route::post('/otp-verify', [AuthenticationController::class, 'otpVerification'])->name('otpVerification');
Route::post('/otp-resend',[AuthenticationController::class, 'otpResend'])->name('otpResend');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/update-password',[AuthenticationController::class,'resetpassword'])->name('resetpassword');


Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/add-task', [ActivityController::class, 'addTask'])->name('addTask');
    Route::post('/taskCompleted', [ActivityController::class, 'taskCompleted'])->name('taskCompleted');
    Route::get('/home',[HomeController::class,'index'])->name('home');
    Route::get('/date-activity',[HomeController::class,'dateActivity'])->name('dateActivity');
    Route::post('/delete-activity',[ActivityController::class, 'DeleteActivity'])->name('deleteActivity');
    Route::get('/calendar',[HomeController::class,'calendar'])->name('calendar');



    Route::post('/contactUs',[ContactusController::class,'contactuspost'])->name('contactus');
    Route::get('/contactdetails',[ContactusController::class,'contactdetails'])->name('contactdetails');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});