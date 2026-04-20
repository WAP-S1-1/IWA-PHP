<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IWA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    main {
        background-image: url("{{ asset('background-sky.webp') }}");
        background-size: cover;
        min-height: 100vh;
        padding: 20px;
    }
    .nav-tabs .nav-link{
        color: #0a0a0a;
    }
    .nav-tabs .nav-link.active,
    .nav-tabs .nav-item.show .nav-link {
        color: white !important;
        background-color: #B20A0E !important;
    }
     .resizable-text {
         font-size: clamp(0.75rem, 2vw, 1rem);
         overflow: hidden;
         white-space: normal;
         word-break: break-word;
     }
</style>
<body>
<nav class="d-flex align-items-center justify-content-between border-bottom border-3" style=background-color:#F5F5F5>
    <img src="{{ asset('LogoIWA-text.png') }}" alt="Logo IWA" class="ms-3" style="height: 65px;">
    <ul class="nav nav-tabs justify-content-end" >
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link " id="home-tab" href="#home" role="tab">Home</a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" id="users-tab" href="#users" role="tab" >Gebruikers</a>--}}
{{--        </li>--}}
        @auth
            @if(auth()->user()->hasRole(['Administrator', 'Administratief medewerker']))
        <li class="nav-item">
            <a class="nav-link resizable-text {{ request()->routeIs('users.index') ? 'active' : '' }}"
               id="users-tab" href="{{ route('users.index') }}" role="tab" >Gebruikers</a>
        </li>
            @endif
                @if(auth()->user()->hasRole(['Administrator', 'Commercieel medewerker']))
        <li class="nav-item">
            <a class="nav-link resizable-text {{ request()->routeIs('subscription.index') ? 'active' : '' }} || {{ request()->routeIs('companies.index') ? 'active' : '' }}"
               id="subscriptions-tab"  href="{{ route('subscription.index') }}" role="tab">Abonnementen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link resizable-text {{ request()->routeIs('contracts.index') ? 'active' : '' }}"
               id="contracts-tab" href="{{ route('contracts.index') }}" role="tab">Contracten</a>
        </li>
                @endif
                @if(auth()->user()->hasRole(['Administrator', 'Technisch medewerker']))
        <li class="nav-item">
            <a class="nav-link resizable-text {{ request()->routeIs('monitoring.index') ? 'active' : '' }}"
               id="monitor-tab" href="{{ route('monitoring.index') }}" role="tab">Monitoring</a>
        </li>
                @endif
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link {{ request()->routeIs('api.index') ? 'active' : '' }}"--}}
{{--               id="API-tab" href="#API" role="tab" >API beheer</a>--}}
{{--        </li>--}}
        @endauth
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link resizable-text" style="background: none; border: none; cursor: pointer;">Logout</button>
            </form>
        </li>
    </ul>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

