<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientApiAuthController;
use App\Helpers\ApiResponse;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    if (!auth('api')->check() && !auth('client')->check()) {
        return ApiResponse::forbidden("Anda tidak memiliki akses.");
    }
})->name('login');

// users
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);

// clients
Route::post('client/login', [ClientApiAuthController::class, 'login']);
Route::post('client/logout', [ClientApiAuthController::class, 'logout']);
Route::post('client/refresh', [ClientApiAuthController::class, 'refresh']);

Route::middleware(['auth.multi'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('client_api', ClientApiController::class);
});