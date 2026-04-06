<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\JwtCookieAuth;
use App\Http\Middleware\NoCache;
use App\Http\Middleware\RedirectIfAuthenticatedJwt;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/monitoring');
});

Route::middleware(['web', RedirectIfAuthenticatedJwt::class])->get('/login', function () {
    return view('login');
});

// route voor inloggen
Route::post('/login', [AuthController::class, 'login']);


Route::middleware([JwtCookieAuth::class, NoCache::class])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');;
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');;


//Companies routes

    Route::get('/companies', [CompanyController::class, 'index'])
        ->name('companies.index');


//Subscription routes

    Route::get('/subscription', [SubscriptionController::class, 'index'])
        ->name('subscription.index');

    Route::get('/subscription/create', [SubscriptionController::class, 'create'])
        ->name('subscription.create');

    Route::post('/subscription', [SubscriptionController::class, 'store'])
        ->name('subscription.store');

    Route::get('/subscription/edit/{subscription}', [SubscriptionController::class, 'edit'])
        ->name('subscription.edit');

    Route::put('/subscription/{subscription}', [SubscriptionController::class, 'update'])
        ->name('subscription.update');

    Route::delete('/subscription/{subscription}', [SubscriptionController::class, 'destroy'])
        ->name('subscription.destroy');

//Users routes

    Route::get('/users', [UsersController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UsersController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UsersController::class, 'store'])
        ->name('users.store');

    Route::get('/users/edit/{users}', [UsersController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/{users}', [UsersController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{users}', [UsersController::class, 'destroy'])
        ->name('users.destroy');

//Monitoring routes

    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});
