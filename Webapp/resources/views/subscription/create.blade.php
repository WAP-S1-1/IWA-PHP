@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:fit-content;min-width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
        <h2>Add subscription</h2>
        <form action="{{ route('subscription.store') }}" method="POST" style="width: 300px">
            @csrf
            <div class="mb-3" style="font-weight:500">
                <label for="type" class="form-label">Company *</label>
                <select name="company" class="form-select" style="background-color:rgba(255,255,255,0.4)" required>
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="type" class="form-label">Type *</label>
                <select name="type" class="form-select" style="background-color:rgba(255,255,255,0.4)" required>
                    <option value="">Select Type</option>
                    @foreach($subscription_types as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="start_date" class="form-label">Start-datum *</label>
                <input type="date" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="start_date" name="start_date"  required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="end_date" class="form-label">Eind-datum</label>
                <input type="date" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="end_date" name="end_date">
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="price" class="form-label">Price *</label>
                <input type="number" step="0.01" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="price" name="price" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="identifier" class="form-label">Identifier *</label>
                <input type="text" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="identifier" name="identifier" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="token" class="form-label">Token *</label>
                <input type="text" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="token" name="token" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" style="background-color:rgba(255,255,255,0.4)" id="notes"></textarea>
            </div>
            <button href="{{asset('subscription')}}" type="submit" class="btn btn-dark w-100 p-1">Toevoegen</button>
        </form>
    </div>
@endsection
