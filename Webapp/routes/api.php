<?php

use App\Http\Controllers\WeatherDataController;
use Illuminate\Support\Facades\Route;

Route::post('/postWeatherData', [WeatherDataController::class, 'getWeatherData']);
