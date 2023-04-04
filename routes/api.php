<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthenticationController::class, 'login'])->name('login');
Route::get('user', [ApiUserController::class, 'userdetail'])->name('user');
Route::post('client_details', [ClientController::class, 'addclientinfo'])->name('client_details');
Route::get('products', [ProductController::class, 'productdetails'])->name('products');
Route::get('our_services', [ServiceController::class, 'services'])->name('our_services');
Route::get('portfolio', [PortfolioController::class, 'portfolios'])->name('portfolio');
