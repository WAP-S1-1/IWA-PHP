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
<nav class="d-flex align-items-center justify-content-between border-bottom border-3" style=background-color:#F5F5F5>
    <img src="{{ asset('LogoIWA-text.png') }}" alt="Logo IWA" class="ms-3" style="height: 65px;">
    <ul class="nav nav-tabs justify-content-end" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="users-tab" data-bs-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Gebruikers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="subscriptions-tab" data-bs-toggle="tab" href="#subscriptions" role="tab" aria-controls="subscriptions" aria-selected="false">Abonnementen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contracts-tab" data-bs-toggle="tab" href="#contracts" role="tab" aria-controls="contracts" aria-selected="false">Contracten</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="monitor-tab" data-bs-toggle="tab" href="#monitor" role="tab" aria-controls="monitor" aria-selected="false">Monitoring</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="API-tab" data-bs-toggle="tab" href="#API" role="tab" aria-controls="API" aria-selected="false">API beheer</a>
        </li>
    </ul>
</nav>
<main>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

            </div>
            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">

            </div>
            <div class="tab-pane fade" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-tab">
                @yield('content')
                <h1>@yield('subscriptionHeader')</h1>
                @yield('subscriptionContent') </div>
            <div class="tab-pane fade" id="contracts" role="tabpanel" aria-labelledby="contracts-tab">

            </div>
            <div class="tab-pane fade" id="monitor" role="tabpanel" aria-labelledby="monitor-tab">
                <h1>@yield('monitorHeader')</h1>
                @yield('monitorContent') </div>
            <div class="tab-pane fade" id="API" role="tabpanel" aria-labelledby="API-tab">

            </div>
        </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
