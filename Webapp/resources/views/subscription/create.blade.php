@extends('layouts.app')

@section('title', 'Startpagina')
@section('header', 'Startpagina')

@section('content')
    <div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:550px;height:440px; background-color:rgba(255,255,255,0.5)">
        <form action="{{ route('subscription.store') }}" method="POST" style="width: 300px">
            @csrf
            <div class="mb-3" style="font-weight:500">
                <label for="bedrijfsnaam" class="form-label">Bedrijfsnaam</label>
                <input type="text" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="bedrijfsnaam">
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="type">
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="startdatum" class="form-label">Start-datum</label>
                <input type="date" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="startdatum">
            </div>
            <div class="mb-3" style="font-weight:500">
                <label for="einddatum" class="form-label">Eind-datum</label>
                <input type="date" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="einddatum">
            </div>
            <button href="{{asset('subscription')}}" type="submit" class="btn btn-dark w-100 p-1">Opslaan</button>
        </form>
    </div>
@endsection
