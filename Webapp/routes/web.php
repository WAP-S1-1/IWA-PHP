<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [CommercialDashboardController::class, 'index'])->name('home');


Route::get('/', [AdminDashboardController::class, 'index'])->name('home');

Route::get('/', [ResearcherDashboardController::class, 'index'])->name('home');

Route::get('/', [TechnicalStaffDashboardController::class, 'index'])->name('home');

Route::get('/', [TechnicalAdminDashboardController::class, 'index'])->name('home');

