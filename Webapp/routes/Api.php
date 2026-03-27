<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;


// route voor weerdata ontvangen wat een POST is.
Route::post('/weather', [WeatherController::class, 'store']);


// route voor opvragen (get)
Route::get('/weather', [WeatherController::class, 'index']);

// Route voor het opvragen van data van een specifiek station
Route::get('/weather/station/{stationId}', [WeatherController::class, 'getByStation']);

// route voor de gefilterde satations
Route::get('/stations/filtered', [\App\Http\Controllers\Api\StationController::class, 'getFilteredStations']);





