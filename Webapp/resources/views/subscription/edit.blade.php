@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <div class="card shadow-lg p-4 mx-auto mt-4 align-items-center rounded-5" style="width:fit-content;min-width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
        <h2>Abonnement wijzigen</h2>
        <form action="{{ route('subscription.update', $subscription->id) }}" method="POST" style="width: 300px">
            @csrf
            @method('PUT')
            <div class="mb-3" style="font-weight:500">
                <label for="type" class="form-label">Bedrijf *</label>
                <select name="company" class="form-select" style="background-color:rgba(255,255,255,0.4)" required>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}"
                            {{ $company->id == $subscription->company ? 'selected' : ''}}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="type" class="form-label">Type *</label>
                <select name="type" class="form-select" style="background-color:rgba(255,255,255,0.4)" required>
                    @foreach($subscription_types as $type)
                        <option value="{{ $type->id }}"
                            {{ $type->id == $subscription->type ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row mb-3    ">
                <div class="col-6" style="font-weight:500">
                    <label for="start_date" class="form-label">Start-datum *</label>
                    <input type="date" class="form-control"
                           value="{{ old('start_date', \Carbon\Carbon::parse($subscription->start_date)->format('Y-m-d')) }}"
                           style="background-color:rgba(255,255,255,0.4)" id="start_date" name="start_date" required>
                </div>
                <div class="col-6" style="font-weight:500">
                    <label for="end_date" class="form-label">Eind-datum</label>
                    <input type="date" class="form-control"
                           value="{{ old('end_date', $subscription->end_date ? \Carbon\Carbon::parse($subscription->end_date)->format('Y-m-d') : '')}}"
                           style="background-color:rgba(255,255,255,0.4)" id="end_date" name="end_date">
                </div>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="price" class="form-label">Prijs *</label>
                <input type="number" step="0.01" value="{{$subscription->price}}" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="price" name="price" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="identifier" class="form-label">Identificatie code *</label>
                <input type="text" class="form-control" value="{{$subscription->identifier}}" style="background-color:rgba(255,255,255,0.4)" id="identifier" name="identifier" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="token" class="form-label">Token *</label>
                <input type="text" class="form-control" value="{{$subscription->token}}" style="background-color:rgba(255,255,255,0.4)" id="token" name="token" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="notes" class="form-label">Notities</label>
                <textarea class="form-control" style="background-color:rgba(255,255,255,0.4)" id="notes" name="notes">{{ old('notes', $subscription->notes) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button href="{{asset('subscription')}}" type="submit" class="btn btn-dark w-100 p-1">Bijwerken</button>
                <a href="{{ route('subscription.index') }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
        <form action="{{ route('subscription.destroy', $subscription->id) }}" method="POST" style="width: 300px"
              onsubmit="return confirm('Weet je zeker dat je dit abonnement wilt verwijderen?');">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger w-100 p-1">
                Verwijderen
            </button>
        </form>
    </div>
@endsection
