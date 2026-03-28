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
        background-image: url("{{ asset('background-sky.jpg') }}");
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
</style>
<body>
<nav class="d-flex align-items-center justify-content-between border-bottom border-3" style="background-color:#F5F5F5;">
    <img src="{{ asset('LogoIWA-text.png') }}" alt="Logo IWA" class="ms-3" style="height: 65px;">
    <ul class="nav me-3">
        <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/subscription">Abonnementen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/monitoring">Monitoring</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/logout">LOGOUT</a>
        </li>
    </ul>
</nav>

<main>
    @hasSection('content')
        @yield('content')
    @elseif(View::hasSection('monitorContent'))
        @yield('monitorContent')
    @endif
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
