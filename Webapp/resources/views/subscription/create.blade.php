@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:500px;height:fit-content; background-color:rgba(255,255,255,0.5)">
        <h2>Add subscription</h2>

        @if(session('success'))
            <div>{{ session('success') }}</div>
        @endif

        <form action="{{ route('subscription.store') }}" method="POST" style="width: 300px">
            @csrf
            <div class="mb-3" style="font-weight:500">
                <select name="company" class="form-control" style="background-color:rgba(255,255,255,0.4)">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="type" class="form-label">Type</label>
                <select name="type" class="form-control" style="background-color:rgba(255,255,255,0.4)">
                    <option value="">Select Type</option>
                    @foreach($subscription_types as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="startdatum" class="form-label">Start-datum</label>
                <input type="date" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="startdatum" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="einddatum" class="form-label">Eind-datum</label>
                <input type="date" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="einddatum">
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="price" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="identifier" class="form-label">Identifier</label>
                <input type="text" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="identifier" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="token" class="form-label">Token</label>
                <input type="text" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="token" required>
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" style="background-color:rgba(255,255,255,0.4)" id="notes"></textarea>
            </div>
            <button href="{{asset('subscription')}}" type="submit" class="btn btn-dark w-100 p-1">Opslaan</button>
        </form>
    </div>
@endsection
