<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JWT Full Test Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 40px auto;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }

        button {
            cursor: pointer;
        }

        pre {
            background: #111;
            color: #0f0;
            padding: 10px;
            overflow: auto;
        }

        .row {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>JWT Full Test Dashboard</h1>

<!-- LOGIN -->
<div class="row">
    <h2>Login</h2>

    <input type="email" id="email" placeholder="Email">
    <input type="password" id="password" placeholder="Password">

    <button onclick="login()">Login</button>
</div>

<!-- ACTIONS -->
<div class="row">
    <h2>Actions</h2>

    <button onclick="checkMe()">Check /me</button>
    <button onclick="logout()">Logout</button>
</div>

<!-- OUTPUTS -->
<div class="row">
    <h2>Token</h2>
    <pre id="tokenOut"></pre>
</div>

<div class="row">
    <h2>Decoded JWT</h2>
    <pre id="decodedOut"></pre>
</div>

<div class="row">
    <h2>Response</h2>
    <pre id="output"></pre>
</div>

<script>
    const API_BASE = "IWA/contracten";

    function getToken() {
        return localStorage.getItem("token");
    }

    function print(data) {
        document.getElementById("output").textContent =
            JSON.stringify(data, null, 2);
    }

    function showToken(token) {
        document.getElementById("tokenOut").textContent = token || "No token";
    }

    function parseJwt(token) {
        try {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map(c =>
                '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)
            ).join(''));

            return JSON.parse(jsonPayload);
        } catch (e) {
            return { error: "Invalid token" };
        }
    }

    async function login() {
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        const res = await fetch(`${API_BASE}/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();

        print({ endpoint: "/login", status: res.status, response: data });

        if (data.token) {
            localStorage.setItem("token", data.token);

            showToken(data.token);

            const decoded = parseJwt(data.token);
            document.getElementById("decodedOut").textContent =
                JSON.stringify(decoded, null, 2);
        }
    }

    async function checkMe() {
        const token = getToken();

        if (!token) {
            print({ error: "No token found" });
            return;
        }

        const res = await fetch(`${API_BASE}/me`, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        });

        let data;
        try {
            data = await res.json();
        } catch {
            data = { error: "Invalid JSON response" };
        }

        print({
            endpoint: "/me",
            status: res.status,
            response: data
        });

        // ✅ Only now decide if token is invalid
        if (res.status === 401 || res.status === 403 || data.error === "invalid_token") {
            clearAuth();
        }
    }

    function clearAuth() {
        localStorage.removeItem("token");
        showToken(null);
        document.getElementById("decodedOut").textContent = "";
    }

    async function logout() {
        const token = getToken();

        const res = await fetch(`${API_BASE}/logout`, {
            method: "POST",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        });

        const data = await res.json();

        print({
            endpoint: "/logout",
            status: res.status,
            response: data
        });

        //localStorage.removeItem("token");
        //showToken(null);
        //document.getElementById("decodedOut").textContent = "";
    }
</script>

</body>
</html>
