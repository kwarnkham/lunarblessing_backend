<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TelegramWebhookController;
use App\Http\Controllers\UserController;
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

Route::post('/' . config('app')['telegram_bot_token'], [TelegramWebhookController::class, 'handle']);

Route::post('fb-data-delete', [AuthController::class, 'fbDataDelete']);


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('login/fb', 'loginWithFacebook');
    Route::post('login/google', 'loginWithGoogle');
    Route::post('login/telegram', 'loginWithTelegram');
    Route::post('password', 'changePassword')->middleware('auth:sanctum');
    Route::get('check-token', 'checkToken')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::put('user', 'update');
    Route::post('user/setting/{user}', 'changeSetting');
});


Route::controller(ItemController::class)->group(function () {
    Route::get('item', 'index');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('payment', 'index');
});

Route::middleware('auth:sanctum')->controller(OrderController::class)->group(function () {
    Route::post('order', 'store');
    Route::get('order/{order}', 'show');
    Route::get('order', 'index');
    Route::put('order/{order}', 'update');
    Route::put('order/{order}/product', 'updateItems');
    Route::post('order/status/{order}', 'updateStatus');
    Route::post('order/pay/{order}', 'pay');
    Route::post('order/check-paid/{order}', 'checkPaid');
});
