<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WeatherStationController;

use App\Http\Controllers\Api\StationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stations', function () {
    return view('weatherstations');
});

Route::prefix('api')->get('/stations', [StationController::class, 'index']);
