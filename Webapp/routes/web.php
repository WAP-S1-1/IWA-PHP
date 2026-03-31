<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\JwtCookieAuth;
use App\Http\Middleware\RedirectIfAuthenticatedJwt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUser;


Route::get('/', function () {
    return redirect('/monitoring');
});

Route::middleware(['web', RedirectIfAuthenticatedJwt::class])->get('/login', function () {
    return view('login');
});

// route voor inloggen
Route::post('/login', [AuthController::class, 'login']);


Route::middleware([JwtCookieAuth::class])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');;
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');;

    Route::get('/subscription', [SubscriptionController::class, 'index'])
        ->name('subscription.index');

    Route::get('/companies', [CompanyController::class, 'index'])
        ->name('companies.index');

    Route::get('/subscription', [SubscriptionController::class, 'index'])
        ->name('subscription.index');

    Route::get('/subscription/create', [SubscriptionController::class, 'create'])
        ->name('subscription.create');

    Route::post('/subscription', [SubscriptionController::class, 'store'])
        ->name('subscription.store');

    Route::get('/subscription/{id}', [SubscriptionController::class, 'edit'])
        ->name('subscription.edit');

    Route::put('/subscription/{id}', [SubscriptionController::class, 'update'])
        ->name('subscription.update');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring.index');

});

Route::post('/register', [AuthController::class, 'store']);

Route::get('/register', [RegisterUser::class, 'index']);
