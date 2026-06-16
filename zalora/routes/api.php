<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExternalProxyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user_login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/user_logout', [AuthController::class, 'logout']);
    Route::get('/user_me',      [AuthController::class, 'me']);
});

Route::middleware(['auth:api', 'role:admin,staff'])->group(function () {
    Route::apiResource('/users', UserController::class);
});

Route::middleware('auth:api')->group(function () {
    Route::any('{any}', ExternalProxyController::class)
        ->where('any', '.*');
});
