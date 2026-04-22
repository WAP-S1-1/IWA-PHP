@extends('layouts.app')

@section('title', 'Update Password')
@section('content')
    <div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
        <h2>Wachtwoord wijzigen</h2>
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible" style="width: fit-content; align-self: center">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('password.update', $user->id) }}" method="POST" style="width: 300px">
            @csrf
            @method('PUT')

            <div class="mb-3" style="font-weight: 500">
                <label>Nieuw wachtwoord *</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3" style="font-weight: 500">
                <label>Herhaal wachtwoord *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 p-1">Wijzig wachtwoord</button>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
@endsection
