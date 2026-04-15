@extends('layouts.app')

@section('title', 'Contract toevoegen')
@section('header', 'Contract toevoegen')

@section('content')
    <div style="display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem;">
        <div class="card shadow-lg p-4 rounded-5 align-items-center" style="width:fit-content;min-width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
            <h2>Nieuw contract toevoegen</h2>
            <form id="contractForm" action="{{ route('contracts.store') }}" method="POST" style="width: 300px">
                @csrf
                <div class="mb-3" style="font-weight:500">
                    <label for="company_id" class="form-label">Bedrijf</label>
                    <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" style="background-color:rgba(255,255,255,0.4)">
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
                    <label for="url" class="form-label">URL</label>
                    <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror"
                           style="background-color: rgba(255,255,255,0.4)" maxlength="100" value="{{ old('url') }}">
                    @error('url')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark flex-grow-1">Contract Opslaan</button>
                    <a href="{{ route('contracts.index') }}" class="btn btn-danger">Annuleren</a>
                </div>
            </form>
        </div>


@endsection
