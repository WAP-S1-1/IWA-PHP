<?php

use App\Http\Controllers\NewDataController;
use Illuminate\Support\Facades\Route;

Route::post('/postWeatherData', [NewDataController::class, 'handle']);
