@extends('layouts.app')

@php
    use App\Models\Station;
@endphp

@section('title', 'Monitoring weerstations')
@section('content')
    <style>
        .stations-card{
            width: 18rem;
            margin: 1rem;
            border-radius: 0.5rem;
            min-height: 260px;
            max-height: 300px;
            overflow: hidden;
        }
        #stations-scroll {
            max-height: 100%;
            overflow-y: auto;
        }
        .resizable-text {
            min-width: 0;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }
        h2{text-align:center; color:#294B71;padding-top: 21px}
        h1{text-align:center; color:white;padding-top: 21px}
        p{font-weight: bold; color:#294B71 }
    </style>
<div class="card shadow-lg mx-auto mt-5 align-items-center rounded-top-4 overflow-hidden resizable-text" style="width:86%;height:10vh;background-color:#262626;">
    <h1>Alle weerstations</h1>
</div>
    <div class="card shadow-lg p-4 mx-auto align-items-center rounded-bottom-4 overflow-hidden"
         style="width:86%; background-color:rgba(255,255,255,0.5)">
        <div class="d-flex justify-content-center gap-2 mb-3">
            <a href="{{ route('monitoring.index', ['status' => null]) }}"
               class="btn btn-sm {{ ($filter ?? '') === '' ? 'btn-dark' : 'btn-outline-dark' }}">
                Alle
            </a>
            <a href="{{ route('monitoring.index', ['status' => Station::STATUS_OFFLINE]) }}"
               class="btn btn-sm {{ ($filter ?? '') === Station::STATUS_OFFLINE ? 'btn-danger' : 'btn-outline-danger' }}">
                Offline
            </a>
            <a href="{{ route('monitoring.index', ['status' => Station::STATUS_ERROR]) }}"
               class="btn btn-sm {{ ($filter ?? '') === Station::STATUS_ERROR ? 'btn-warning' : 'btn-outline-warning' }}">
                Error
            </a>
            <a href="{{ route('monitoring.index', ['status' => Station::STATUS_ONLINE]) }}"
               class="btn btn-sm {{ ($filter ?? '') === Station::STATUS_ONLINE ? 'btn-success' : 'btn-outline-success' }}">
                Online
            </a>
        </div>

        <div id="stations-scroll" class="w-100" style="height:65vh; overflow:hidden; overflow-y:auto;">
            <div id="stations-container" class="row p-4 g-4 justify-content-center overflow-hidden">
                @foreach($stations as $station)
                    @php
                        $firstGeo = $station->geolocations->first() ?? null;
                        $country = $firstGeo->country ?? 'Country';
                        $city = $firstGeo->city ?? 'City';
                    @endphp


                    <div class="col-auto"> <a href="{{ route('stations.measurements', $station) }}" class="text-decoration-none d-block">
                        <div class="card stations-card">
                            <div class="card-body p-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                    <h2 class="name mb-0 pt-0">Station {{ $station->name }}</h2>

                                    <svg class="
                                    {{
                                        ($station->status === Station::STATUS_ONLINE ? 'text-success' :
                                        ($station->status === Station::STATUS_ERROR ? 'text-warning' :
                                        'text-danger'))
                                    }}
                                    "
                                         width="18" height="18" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="8" fill="currentColor" />
                                    </svg>
                                </div>
                                <hr>
                                <p>
                                    <img src="location.svg" class="me-2" style="width:40px; vertical-align:middle;">
                                    <span class="location-text">{{ $country }}, {{ $city }}</span>
                                </p>
                                <p>Longitude {{ $station->longitude ?? '' }}</p>
                                <p>Latitude {{ $station->latitude ?? '' }}</p>
                                <p>Elevation {{ $station->elevation ?? '' }} m</p>
                            </div>
                        </div>
                        </a>
                    </div>

                @endforeach
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $stations->appends(request()->query())->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>
@endsection
