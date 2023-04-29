<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AppStaticPageController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\Icon;
use App\Http\Controllers\Admin\IconController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaticContentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactusController;
use App\Http\Controllers\Admin\ContactDetailsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticateController::class, 'loginView'])->name('admin.login');
Route::post('/authenticate', [AuthenticateController::class, 'loginPost'])->name('admin.login.post');
Route::get('/logout', [AuthenticateController::class, 'logout'])->name('admin.logout');


Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {

    Route::get('dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('user', CustomerController::class);
    Route::post('change-status', [CustomerController::class, 'change_status'])->name('change_status');
    Route::resource('category', CategoryController::class);
    Route::resource('activity', ActivityController::class);
    Route::resource('transaction', TransactionController::class);
    Route::resource('static_content', StaticContentController::class);
    Route::resource('contactus',ContactusController::class);
    Route::resource('contactdetails',ContactDetailsController::class);
    Route::resource('icon', IconController::class);
});

