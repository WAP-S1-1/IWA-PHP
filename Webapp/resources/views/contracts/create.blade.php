@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <div class="card shadow-lg p-4 mx-auto mt-4 align-items-center rounded-5" style="width:fit-content;min-width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
        <h2>Nieuw contract toevoegen</h2>
        <form action="{{ route('contracts.store') }}" method="POST" style="width: 300px">
            @csrf
            <div class="mb-3" style="font-weight:500">
                <label for="company_id" class="form-label">Bedrijf *</label>
                <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)" required>
                    <option value="">Selecteer een bedrijf</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
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
                <textarea class="form-control @error('omschrijving') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)" id="omschrijving" name="omschrijving" required>{{ old('omschrijving') }}</textarea>
                @error('omschrijving')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="row mb-3">
                <div class="col-6" style="font-weight:500">
                    <label for="start_datum" class="form-label">Start-datum *</label>
                    <input type="date" class="form-control @error('start_datum') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)" id="start_datum" name="start_datum" value="{{ old('start_datum') }}" required>
                    @error('start_datum')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6" style="font-weight:500">
                    <label for="eind_datum" class="form-label">Eind-datum</label>
                    <input type="date" class="form-control @error('eind_datum') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)" id="eind_datum" name="eind_datum" value="{{ old('eind_datum') }}">
                    @error('eind_datum')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3" style="font-weight:500">
                <label for="url" class="form-label">URL *</label>
                <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror"
                       style="background-color: rgba(255,255,255,0.4)" maxlength="100" value="{{ old('url') }}" required>
                @error('url')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <fieldset class="mb-3 p-3 border rounded" style="background-color: rgba(255,255,255,0.3)">
                <legend class="fw-bold">Query's (Optioneel)</legend>
                <p class="text-muted small">Voeg tot 3 queries toe</p>

                @for($i = 1; $i <= 3; $i++)
                    <div class="mb-2">
                        <label for="queries_{{ $i }}" class="form-label">Query {{ $i }}</label>
                        <input type="text"
                               name="queries[]"
                               id="queries_{{ $i }}"
                               class="form-control @error('queries.*') is-invalid @enderror"
                               style="background-color:rgba(255,255,255,0.4)"
                               placeholder="Omschrijving van query {{ $i }}"
                               value="{{ old('queries.' . ($i-1)) }}"
                               maxlength="256">
                    </div>
                @endfor
                @error('queries.*')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </fieldset>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark flex-grow-1">Contract Opslaan</button>
                <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>


@endsection
