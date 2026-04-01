@extends('layouts.app')

@section('title', 'Register New User')
@section('content')
<body>
<div class="container mt-5">
    <div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:fit-content;min-width:550px;height:fit-content; background-color:rgba(255,255,255,0.5)">
    <h2 class=" align-items-center">Nieuwe gebruiker registreren</h2>
    <form method="POST" style="width: 300px">
        <!-- CSRF token for Laravel -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="mb-3" style="font-weight:500">
            <label for="name" class="form-label">Achternaam *</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="first_name" class="form-label">Voornaam</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Voornaam">
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="initials" class="form-label">Afkortingen</label>
            <input type="text" class="form-control" id="initials" name="initials" placeholder="Afkortingen">
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
            <label for="employee_code" class="form-label">Personeelsnummer *</label>
            <input type="text" class="form-control" id="employee_code" name="employee_code">
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="user_role" class="form-label">Rol</label>
            <select class="form-select" id="user_role" name="user_role" required>
                <option value="">Selecteer een rol</option>
                <option value="1">Technisch medewerker - Medewerker van de afdeling monitoring en beheer</option>
                <option value="2">Technisch onderzoeker - Medewerker van de afdeling analyse en datamining</option>
                <option value="3">Commercieel medewerker - Medewerker van de afdeling marketing en klant beheer</option>
                <option value="4">Administratief medewerker - Medewerker van de afdeling personeelszaken</option>
                <option value="5">Technisch beheerder - Medewerker van de afdeling IT-support</option>
                <option value="6">Administrator - Super user</option>
            </select>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="password" class="form-label">Wachtwoord *</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="password_confirmation" class="form-label">Herhaal wachtwoord *</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-dark w-100 p-1">Toevoegen</button>
    </form>
</div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
