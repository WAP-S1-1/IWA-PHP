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
<div class="card shadow-lg p-4 mx-auto mt-5 align-items-center rounded-5" style="width:550px;height:440px; background-color:rgba(255,255,255,0.5)">
    <img src="LogoIWA.png" alt="Logo">
    <form method="POST" action="{{ route('password.check') }}">
        @csrf

        <div class="mb-3">
            <label>Personeelsnummer</label>
            <input type="text" name="employee_code" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Doorgaan
        </button>
    </form>
</div>
</body>
</html>
