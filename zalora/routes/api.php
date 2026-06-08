<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExternalProxyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user_login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/user_logout', [AuthController::class, 'logout']);
    Route::get('/user_me',      [AuthController::class, 'me']);

    Route::post('/users',     [UserController::class, 'store']);
    Route::get('/users',        [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::any('{any}', ExternalProxyController::class)
        ->where('any', '.*');
});
