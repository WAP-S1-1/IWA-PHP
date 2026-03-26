<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// route voor inloggen
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'store']);

Route::get('test', function (Request $request) {
    return "test";
});



