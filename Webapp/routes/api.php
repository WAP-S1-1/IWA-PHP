<?php

use App\Http\Controllers\NewDataController;
use App\Http\Controllers\WeatherDataController;
use Illuminate\Support\Facades\Route;

Route::post('/postWeatherData', [NewDataController::class, 'handle']);
