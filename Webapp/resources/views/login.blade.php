<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background-image: url('background-sky.webp');
    }
</style>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:550px; min-height:440px; height: fit-content; background-color:rgba(255,255,255,0.5)">
    <img src="LogoIWA.png" alt="Logo" style="margin-bottom: 10px">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible" style="width: fit-content; align-self: center">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible" style="width: fit-content; align-self: center">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" style="width:300px">
        <!-- CSRF token for Laravel -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="mb-3" style="font-weight:500">
            <label for="employee_code" class="form-label">Personeelscode</label>
            <input type="text" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="employee_code" name="employee_code" required>
        </div>

        <div class="mb-3" style="font-weight:500">
            <label for="password" class="form-label">Wachtwoord</label>
            <input type="password" class="form-control" style="background-color:rgba(255,255,255,0.4)" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-dark w-100 p-1">
            Login
        </button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
