<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtCookieAuth;
use App\Http\Middleware\RedirectIfAuthenticatedJwt;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/register', [AuthController::class, 'store']);

// routes/api.php




