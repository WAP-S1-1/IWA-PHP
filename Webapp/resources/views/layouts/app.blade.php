<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Weerstations App')</title>
</head>
<body>
<nav>
    <ul>
        <li><a href="{{ route('dashboard') }}">Startpagina</a></li>
        @auth
            @if(auth()->user()->role === 'administratief')
                <li><a href="{{ route('gebruikers.index') }}">Gebruiker administratie</a></li>
            @endif

            @if(auth()->user()->role === 'commercieel')
                <li><a href="{{ route('abonnementen.index') }}">Abonnement registratie</a></li>
                <li><a href="{{ route('contracten.index') }}">Contract registratie</a></li>
            @endif

            @if(in_array(auth()->user()->role, ['technisch_medewerker', 'technisch_onderzoeker']))
                <li><a href="{{ route('monitoring.index') }}">Monitoring weerstations</a></li>
            @endif

            @if(auth()->user()->role === 'technisch_beheerder')
                <li><a href="{{ route('api.index') }}">API beheer</a></li>
            @endif
        @endauth
    </ul>
</nav>

<main>
    <h1>@yield('header')</h1>
    @yield('content')
</main>
</body>
</html>
