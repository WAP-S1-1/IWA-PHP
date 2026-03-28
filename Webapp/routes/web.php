<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ComparingDataController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ApiManagementController;
use App\Http\Controllers\WeatherStationController;
use App\Http\Controllers\Api\StationController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['web', RedirectIfAuthenticatedJwt::class])->get('/login', function () {
    return view('login');
});

// route voor inloggen
Route::post('/login', [AuthController::class, 'login']);


Route::middleware([JwtCookieAuth::class])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/subscription', [SubscriptionController::class, 'index'])
        ->name('subscription.index');

    Route::post('/register', [AuthController::class, 'store']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring.index');

});



