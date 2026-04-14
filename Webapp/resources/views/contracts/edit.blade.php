@extends('layouts.app')

@section('title', 'Contract wijzigen')
@section('header', 'Contract wijzigen')

@section('content')
    <div style="display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem; align-items: stretch;">
        <div class="card shadow-lg p-4 rounded-5 align-items-center" style="width:fit-content;min-width:550px; background-color:rgba(255,255,255,0.5)">
        <h2>Contract bewerken</h2>
            <form id="contractForm" action="{{ route('contracts.update', $contract->id) }}" method="POST" style="width: 300px">
                @csrf
                @method('PUT')
                <div class="mb-3" style="font-weight:500">
                    <label for="company_id" class="form-label">Bedrijf</label>
                    <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)">
                        <option value="">Selecteer een bedrijf</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $contract->company_id) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" style="font-weight:500">
                    <label for="omschrijving" class="form-label">Omschrijving *</label>
                    <textarea class="form-control @error('omschrijving') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)" id="omschrijving" name="omschrijving" required>{{ old('omschrijving', $contract->omschrijving) }}</textarea>
                    @error('omschrijving')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-6" style="font-weight:500">
                        <label for="start_datum" class="form-label">Start-datum *</label>
                        <input type="date" class="form-control @error('start_datum') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)" id="start_datum" name="start_datum" value="{{ old('start_datum', $contract->start_datum?->format('Y-m-d')) }}">
                        @error('start_datum')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6" style="font-weight:500">
                        <label for="eind_datum" class="form-label">Eind-datum</label>
                        <input type="date" class="form-control @error('eind_datum') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)" id="eind_datum" name="eind_datum" value="{{ old('eind_datum', $contract->eind_datum?->format('Y-m-d')) }}">
                        @error('eind_datum')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3" style="font-weight:500">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror"
                           style="background-color: rgba(255,255,255,0.4)" maxlength="100" value="{{ old('url', $contract->url) }}">
                    @error('url')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark flex-grow-1">Contract Opslaan</button>
                    <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Annuleren</a>
                </div>
            </form>
            <form id="deleteForm" action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="width: 300px"
                  onsubmit="return confirm('Weet je zeker dat je dit contract wilt verwijderen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100 p-1">
                    Verwijderen
                </button>
            </form>
        </div>
        <div class="card shadow-lg p-4 rounded-5 align-items-center" style="width:fit-content;min-width:550px; background-color:rgba(255,255,255,0.5); display: flex; flex-direction: column;">

        <h2>Query's bewerken</h2>
            <div style="width: 300px; max-height: 300px; overflow-y: auto;">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" style="width: fit-content; align-self: end">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('success') }}
                    </div>
                @endif
                @forelse($contract->queries as $query)
                    <form id="queryEditForm{{ $query->id }}" action="{{ route('queries.update', $query) }}" method="POST" style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ddd; border-radius: 5px; background-color: rgba(255,255,255,0.3)">
                        @csrf
                        @method('PUT')
                        <div class="mb-3" style="font-weight:500">
                            <label for="query_omschrijving_{{ $query->id }}" class="form-label">Query {{ $loop->iteration }}</label>
                            <textarea class="form-control" style="background-color:rgba(255,255,255,0.4)" id="query_omschrijving_{{ $query->id }}" name="omschrijving" required>{{ $query->omschrijving }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <form id="queryDeleteForm{{ $query->id }}" action="{{ route('queries.destroy', $query) }}" method="POST" style="display: inline;" onsubmit="return confirm('Verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Verwijderen</button>
                            </form>
                        </div>
                    </form>
                @empty
                    <p class="text-muted">Geen queries beschikbaar</p>
                @endforelse
            </div>

            <hr style="margin: 1rem 0;">

            <form id="newQueryForm" action="{{ route('contracts.queries.store', $contract) }}" method="POST" style="width: 300px">
                @csrf
                <div class="mb-3" style="font-weight:500">
                    <label for="new_query" class="form-label">Nieuwe Query</label>
                    <textarea class="form-control" style="background-color:rgba(255,255,255,0.4)" id="new_query" name="query_omschrijving" placeholder="Voeg een nieuwe query toe" required></textarea>
                </div>
                <button type="submit" class="btn btn-dark w-100">+ Query Toevoegen</button>
            </form>

        </div>
    </div>

@endsection
