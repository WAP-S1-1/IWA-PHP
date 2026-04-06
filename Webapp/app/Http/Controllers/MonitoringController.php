<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function index(Request $request): View
    {
//        $filter = $request->query('status', 'all');
//
//        $query = Station::with('geolocations');
//
//        if ($filter !== 'all') {
//            $query->where('status', $filter);
//        }
//
//        $stations = $query
//            ->orderByRaw("
//                CASE status
//                    WHEN 'red' THEN 1
//                    WHEN 'orange' THEN 2
//                    WHEN 'green' THEN 3
//                    ELSE 4
//                END
//            ")
//            ->paginate(12);
//
//        return view('monitoring.index', compact('stations', 'filter'));

        $filter = $request->query('status');

        // Fetch all weather stations
        $query = Station::with(['latestMeasurement', 'geolocations']);

        $stations = $query->get();

        // ChatGPT generated
        // Get last measurement and check if it is online
        foreach ($stations as $station) {
            $last = $station->latestMeasurement;

            $measurementTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $last->date->format('Y-m-d') . ' ' . $last->time->format('H:i:s')
            );

            $station->status = (!$last || $measurementTime->diffInUTCSeconds(now()) > 300)
                ? Station::STATUS_OFFLINE : Station::STATUS_ONLINE;
        }

        if (is_numeric($filter)) {
            // filter Collection by status
            $stations = $stations->filter(fn($station) => $station->status == (int)$filter);
        }

        // 4️⃣ Paginate manually
        $page = request()->page ?? 1;
        $perPage = 12;

        // TODO: Remove this and add last known status to DB so
        //      paginate() and a filter can be used.
        $stations = new LengthAwarePaginator(
            $stations->forPage($page, $perPage)->values(), // <- slice the filtered collection
            $stations->count(), // total items **after filtering**
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()] // optional: preserve query params
        );

        return view('monitoring.index', compact('stations', 'filter'));
    }
}
