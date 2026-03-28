<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtCookieAuth;
use App\Http\Middleware\RedirectIfAuthenticatedJwt;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ComparingDataController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ApiManagementController;
use App\Http\Controllers\Api\StationController;

Route::get('/register', [\App\Http\Controllers\RegisterUser::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stations', function () {
    return view('weatherstations');
});

Route::prefix('api')->get('/stations', [StationController::class, 'index']);

Route::get('/welcome', function () {
    return view('landing.index');
    })->name('landing');

Route::middleware(['web', RedirectIfAuthenticatedJwt::class])->get('/login', function () {
    return view('login');
});

// route voor inloggen
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => [JwtCookieAuth::class], 'handle'], function () {
    Route::get('test', function () {
        return "test";
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/logout', [AuthController::class, 'logout']);
    //Route::get('/profile', [UserController::class, 'profile']);
});


Route::middleware([JwtCookieAuth::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/gebruikers', [UserManagementController::class, 'index'])
        //->middleware('role:administratief')
        ->name('usermanagement.index');

    Route::get('/abonnementen', [SubscriptionController::class, 'index'])
        //->middleware('role:commercieel')
        ->name('subscription.index');

    Route::get('/contracten', [ContractController::class, 'index'])
        //->middleware('role:commercieel')
        ->name('contracts.index');

    Route::get('/api-beheer', [ApiManagementController::class, 'index'])
        //->middleware('role:technisch_beheerder')
        ->name('api.index');

    Route::get('/onderzoeker', [ComparingDataController::class, 'index'])
        //->middleware('role:onderzoeker')
        ->name('compare.index');

    Route::get('/onderzoeker', [DownloadController::class, 'index'])
        //->middleware('role:onderzoeker')
        ->name('download.index');

    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring.index');
});



