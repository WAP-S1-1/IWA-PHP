@extends('layouts.app')

@section('title', 'Station ' . $station->name)

@section('content')
    <style>
        .detail-card {
            background: white;
            border-radius: 1rem;
            border: none;
        }
        .info-label {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 0;
        }
        .info-value {
            color: #294B71;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    </style>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('monitoring.index') }}" class="btn btn-outline-dark rounded-pill">
                <i class="bi bi-arrow-left"></i> ← Terug naar Overzicht
            </a>
            <span class="badge rounded-pill status-badge {{ $station->status === 'orange' ? 'bg-warning' : ($station->status === 'red' ? 'bg-danger' : 'bg-success') }}">
            Status: {{ ucfirst($station->status) }}
        </span>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card detail-card shadow-lg p-4">
                    <h2 class="text-center mb-4" style="color: #294B71;">Station {{ $station->name }}</h2>
                    <hr>

                    @php $geo = $station->geolocations->first(); @endphp

                    <div class="mb-3">
                        <p class="info-label text-center">Locatie</p>
                        <p class="info-value text-center">
                            <img src="{{ asset('location.svg') }}" style="width:20px; vertical-align:middle;">
                            {{ $geo->city ?? 'Onbekend' }}, {{ $geo->country ?? 'Onbekend' }}
                        </p>
                    </div>

                    <div class="row text-center mt-4">
                        <div class="col-6 mb-3">
                            <p class="info-label">Longitude</p>
                            <p class="info-value">{{ $station->longitude }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="info-label">Latitude</p>
                            <p class="info-value">{{ $station->latitude }}</p>
                        </div>
                        <div class="col-6">
                            <p class="info-label">Hoogte</p>
                            <p class="info-value">{{ $station->elevation }} m</p>
                        </div>
                        <div class="col-6">
                            <p class="info-label">Laatste Update</p>
                            <p class="info-value small">{{ $station->status_updated_at ? $station->status_updated_at->format('H:i') : '-' }}</p>
                        </div>
                    </div>

                    @if($station->status_message)
                        <div class="alert alert-light border mt-3 mb-0 small">
                            <strong>Status info:</strong><br>{{ $station->status_message }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card detail-card shadow-lg overflow-hidden">
                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="mb-0">Alle Meetgegevens</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($measurements->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Tijdstip</th>
                                        <th>Temp / Dauw</th>
                                        <th>Luchtdruk (S/Z)</th>
                                        <th>Wind (Snel/Richting)</th>
                                        <th>Zicht / Bewolking</th>
                                        <th>Neerslag / Sneeuw</th>
                                        <th>Condities</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($measurements as $measurement)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $measurement->date->format('d-m-Y') }}</div>
                                                <div class="text-muted small">{{ $measurement->time }}</div>
                                            </td>
                                            <td>
                                                <span class="text-danger">{{ $measurement->temperature ?? '-' }}°C</span><br>
                                                <span class="text-info small">{{ $measurement->dewpoint_temperature ?? '-' }}°C</span>
                                            </td>
                                            <td>
                                                {{ $measurement->air_pressure_station ?? '-' }}<br>
                                                <small class="text-muted">{{ $measurement->air_pressure_sea_level ?? '-' }}</small>
                                            </td>
                                            <td>
                                                {{ $measurement->wind_speed ?? '0' }} km/h<br>
                                                <small class="text-muted">{{ $measurement->wind_direction ?? '-' }}°</small>
                                            </td>
                                            <td>
                                                {{ $measurement->visibility ?? '-' }} km<br>
                                                <small class="text-muted">Bewolking: {{ $measurement->cloud_cover ?? '-' }}%</small>
                                            </td>
                                            <td>
                                                💧 {{ $measurement->percipation ?? '0' }} mm<br>
                                                ❄️ {{ $measurement->snow_depth ?? '0' }} cm
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $measurement->conditions ?? 'Normal' }}</span>
                                                @if($measurement->is_corrected)
                                                    <div class="text-warning small" style="font-size: 0.7rem;">Gecorrigeerd</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3">
                                {{ $measurements->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <div class="p-5 text-center">
                                <p class="text-muted">Geen metingen gevonden voor station <strong>{{ $station->name }}</strong>.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
