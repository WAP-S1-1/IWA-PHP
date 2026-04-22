<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('status');

        // Fetch all weather stations and data
        $query = Station::with(['latestMeasurement', 'geolocations']);

        // Optional filtering
        // TODO: This is terrible, we have to do this differently.
        switch ($filter) {
            case Station::STATUS_ONLINE:
                $query = $query->whereHas('latestMeasurement', function ($q) {
                    $q->where(function ($q2) {
                        // Date and time limit, can use indexes
                        $thresholdDate = now()->subSeconds(300)->toDateString();
                        $thresholdTime = now()->subSeconds(300)->toTimeString();

                        $q2->where('date', '>', $thresholdDate)
                            ->orWhere(function ($q3) use ($thresholdDate, $thresholdTime) {
                                $q3->where('date', $thresholdDate)
                                    ->where('time', '>=', $thresholdTime);
                            });
                    });
                });
                break;
            case Station::STATUS_OFFLINE:
                $query = $query->where(function ($q) {
                    $thresholdDate = now()->subSeconds(300)->toDateString();
                    $thresholdTime = now()->subSeconds(300)->toTimeString();

                    $q->whereDoesntHave('latestMeasurement')
                        ->orWhereHas('latestMeasurement', function ($q2) use ($thresholdDate, $thresholdTime) {
                            $q2->where(function ($q3) use ($thresholdDate, $thresholdTime) {
                                $q3->where('date', '<', $thresholdDate)
                                    ->orWhere(function ($q4) use ($thresholdDate, $thresholdTime) {
                                        $q4->where('date', $thresholdDate)
                                            ->where('time', '<', $thresholdTime);
                                    });
                            });
                        });
                });
                break;
            case Station::STATUS_ERROR:
                $query = $query->where('last_100_bad_count', '>=', 1)->whereHas('latestMeasurement', function ($q) {
                    $q->where(function ($q2) {
                        // Date and time limit, can use indexes
                        $thresholdDate = now()->subSeconds(300)->toDateString();
                        $thresholdTime = now()->subSeconds(300)->toTimeString();

                        $q2->where('date', '>', $thresholdDate)
                            ->orWhere(function ($q3) use ($thresholdDate, $thresholdTime) {
                                $q3->where('date', $thresholdDate)
                                    ->where('time', '>=', $thresholdTime);
                            });
                    });
                });
                break;

            default:
                break;
        }
        $stations = $query->paginate(12);

        foreach ($stations as $station) {
            if (is_null($filter)) {

                $last = $station->latestMeasurement;

                if (!$last) {
                    $station->status = Station::STATUS_OFFLINE;
                } else {
                    $measurementTime = Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $last->date->format('Y-m-d') . ' ' . $last->time->format('H:i:s')
                    );

                    $station->status = ($measurementTime->diffInUTCSeconds(now()) > 300)
                        ? Station::STATUS_OFFLINE : Station::STATUS_ONLINE;
                }
            } else {
                $station->status = $filter;
            }
        }

        return view('monitoring.index', compact('stations', 'filter'));
    }

    public function showMeasurements($station_name)
    {
        $station = Station::with(['geolocations', 'latestMeasurement'])->where('name', $station_name)->firstOrFail();

        // Calculate status dynamically based on latest measurement
        $last = $station->latestMeasurement;

        if (!$last) {
            $station->status = Station::STATUS_OFFLINE;
        } else {
            // Use exact same logic as index() method
            $measurementTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $last->date->format('Y-m-d') . ' ' . $last->time->format('H:i:s')
            );

            // First determine if online or offline based on recency
            $station->status = ($measurementTime->diffInUTCSeconds(now()) > 300)
                ? Station::STATUS_OFFLINE : Station::STATUS_ONLINE;

            // Then override to ERROR if it has errors AND is still online
            if ($station->status === Station::STATUS_ONLINE &&
                ($station->last_100_bad_count >= 1 || $last->temperature === null || $last->air_pressure_station === null)) {
                $station->status = Station::STATUS_ERROR;
            }
        }

        // Get measurements
        $measurements = Measurement::where('station', $station->name)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(20);

        return view('monitoring.measurements', compact('measurements', 'station'));
    }


}
