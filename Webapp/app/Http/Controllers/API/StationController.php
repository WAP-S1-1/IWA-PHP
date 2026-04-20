<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\NearestLocation;
use App\Models\Station;

class StationController extends Controller
{
    public function handle($identifier, $name)
    {
        $contract = Contract::query()->findOrFail($identifier);

        $station = Station::query()->findOrFail($name);

        $nearestLocations = NearestLocation::query()
            ->where('station_name', $station->name)
            ->get();

        return response()->json([
            "data" => [
                "station" => $station,
                "nearest_locations" => $nearestLocations,
            ]
        ]);
    }
}
