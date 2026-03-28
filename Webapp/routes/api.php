<?php

use App\Http\Controllers\Api\WeatherDataController;
use Illuminate\Support\Facades\Route;

Route::post('/postWeatherData', [WeatherDataController::class, 'getWeatherData']);

