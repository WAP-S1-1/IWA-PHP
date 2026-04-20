@extends('layouts.app')

@section('title', 'Register New User')
@section('content')
    <div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:fit-content;min-width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
        <h2>Gebruiker wijzigen</h2>
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible" style="width: fit-content; align-self: center">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('users.update', $user->id) }}" method="POST" style="width: 300px">
            @csrf
            @method('PUT')
            <div class="row mb-3" style="font-weight: 500">
                <div class="col-6" style="font-weight:500">
                    <label for="first_name" class="form-label">Voornaam</label>
                    <input type="text" class="form-control" value="{{ $user->first_name }}" id="first_name" name="first_name" placeholder="Voornaam">
                </div>
                <div class="col-6" style="font-weight:500">
                    <label for="initials" class="form-label">Voorletters</label>
                    <input type="text" class="form-control" value="{{ $user->initials }}" id="initials" name="initials" placeholder="Voorletters">
                </div>
            </div>

            <div class="row mb-3" style="font-weight: 500">
                <div class="col-6" style="font-weight:500">
                    <label for="name" class="form-label">Achternaam *</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" id="name" name="name" required>
                </div>
                <div class="col-6" style="font-weight:500">
                    <label for="prefix" class="form-label">Tussenvoegsel</label>
                    <input type="text" class="form-control" value="{{ $user->prefix }}" id="prefix" name="prefix" placeholder="Tussenvoegsel">
                </div>
            </div>

            <div class="mb-3" style="font-weight:500">
                <label for="email" class="form-label">E-mail *</label>
                <input type="email" class="form-control" value="{{ $user->email }}" id="email" name="email" required>
            </div>
            
            <div class="mb-3" style="font-weight:500">
                <label for="user_role" class="form-label">Rol *</label>
                <select class="form-select" id="user_role" name="user_role" required
                        hx-post="{{ route('users.get-prefix') }}"
                        hx-target="#employee_code"
                        hx-swap="outerHTML"
                        hx-headers='{"X-Requested-With":"XMLHttpRequest"}'>
                    <option value="">Selecteer een rol</option>
                    @foreach($userroles as $userrole)
                        <option value="{{ $userrole->id }}"
                            {{ $userrole->id == $user->user_role ? 'selected' : '' }}>
                            {{ $userrole->role }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" style="font-weight:500">
                <label for="employee_code" class="form-label">Personeelscode *</label>
                <input type="text" class="form-control" value="{{ $user->employee_code }}" id="employee_code" name="employee_code">
            </div>

            <div class="mb-3" style="font-weight:500">
                <a href="{{ route('password.edit', $user->id) }}"
                   class="btn btn-warning w-100 mt-2">
                    Wachtwoord Wijzigen
                </a>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100 p-1">Gebruiker Opslaan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="width: 300px"
              onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger w-100 p-1">
                Verwijderen
            </button>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
@endsection
