<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\WeatherDataController;
use App\Models\Station;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\SubscriptionController;

use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ComparingDataController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ApiManagementController;
use App\Http\Controllers\WeatherStationController;
use App\Http\Controllers\Api\StationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stations', function () {
    return view('weatherstations.js');
});

Route::prefix('api')->get('/stations', [StationController::class, 'index']);

Route::prefix('api')->get('/companies', function () {
    $companies = DB::table('companies as c')
        ->select([
            'c.id',
            'c.name',
            'c.city',
            'c.street',
            'c.number',
            'c.number_additional',
            'c.zip_code',
            'c.country',
            'c.email',
        ])
        ->get();

    return response()->json($companies);
});

Route::prefix('api')->get('/subscriptions', function () {
    $subscriptions = DB::table('subscriptions as s')
        ->leftJoin('companies as c', 'c.id', '=', 's.company')
        ->leftJoin('subscription_types as st', 'st.id', '=', 's.type')
        ->select([
            's.id',
            'c.name as company_name',
            'st.name as type_name',
            's.start_date',
            's.end_date',
            's.price',
            'st.description',
            'st.price_per_station',
            's.notes',
        ])
        ->get();

    return response()->json($subscriptions);
});

Route::get('/welcome', function () {
    return view('landing.index');
    })->name('landing');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/companies', [CompanyController::class, 'index'])
    ->name('companies.index');

Route::get('/subscription', [SubscriptionController::class, 'index'])
    ->name('subscription.index');

Route::get('/monitoring', [MonitoringController::class, 'index'])
    ->name('monitoring.index');

// route voor de gefilterde satations
Route::get('/stations/filtered', [\App\Http\Controllers\Api\StationController::class, 'getFilteredStations']);

Route::get('/assets/weatherstations.js', function () {
    $path = resource_path('js/weatherstations.js');
    abort_unless(file_exists($path), 404);
    $compiled = Blade::render(file_get_contents($path), [
        'stations' => station::all(),
    ]);
    return Response::make($compiled, 200, [
        'Content-Type' => 'application/javascript; charset=UTF-8',
    ]);
    })->name('assets.weatherstations.js');
