<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
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


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('login/fb', 'loginWithFacebook');
    Route::get('check-token', 'checkToken')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::put('user', 'update');
});


Route::controller(ItemController::class)->group(function () {
    Route::get('item', 'index');
});

Route::middleware('auth:sanctum')->controller(OrderController::class)->group(function () {
    Route::post('order', 'store');
    Route::get('order/{order}', 'show');
    Route::get('order', 'index');
});
