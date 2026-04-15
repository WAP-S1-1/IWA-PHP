@extends('layouts.app')

@section('title', 'Register New User')
@section('content')
<div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:fit-content;min-width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
    <h2>Nieuwe gebruiker registreren</h2>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible" style="width: fit-content; align-self: center">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('error') }}
        </div>
    @endif
        <form action="{{ route('users.store') }}" method="POST" style="width: 300px">
        @csrf
        <div class="mb-3" style="font-weight:500">
            <label for="name" class="form-label">Achternaam *</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="first_name" class="form-label">Voornaam</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Voornaam">
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="initials" class="form-label">Voorletters</label>
            <input type="text" class="form-control" id="initials" name="initials" placeholder="Voorletters">
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="prefix" class="form-label">Tussenvoegsel</label>
            <input type="text" class="form-control" id="prefix" name="prefix" placeholder="Tussenvoegsel">
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="email" class="form-label">E-mail *</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="employee_code" class="form-label">Personeelscode *</label>
            <input type="text" class="form-control" id="employee_code" name="employee_code" required>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="user_role" class="form-label">Rol *</label>
            <select class="form-select" id="user_role" name="user_role" required>
                <option value="">Selecteer een rol</option>
                @foreach($userroles as $userrole)
                    <option value="{{ $userrole->id }}">
                        {{ $userrole->role }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="password" class="form-label">Wachtwoord *</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="password_confirmation" class="form-label">Bevestig wachtwoord *</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100 p-1">Gebruiker Opslaan</button>
            <a href="{{ route('users.index') }}" class="btn btn-danger">Annuleren</a>
        </div>

    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
