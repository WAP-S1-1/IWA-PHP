<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JWT Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #0f172a;
            color: #e2e8f0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: #1e293b;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .card h2 {
            margin-top: 0;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
        }

        input {
            background: #0f172a;
            color: white;
            border: 1px solid #334155;
        }

        button {
            background: #3b82f6;
            color: white;
            font-weight: bold;
            transition: 0.2s;
        }

        button:hover {
            background: #2563eb;
        }

        .actions button {
            margin-top: 10px;
        }

        .full-width {
            grid-column: span 2;
        }

        pre {
            background: black;
            padding: 15px;
            border-radius: 10px;
            max-height: 250px;
            overflow: auto;
            font-size: 12px;
            white-space: pre-wrap;      /* wrap long lines */
            word-break: break-all;     /* break long tokens */
        }

    </style>
</head>
<body>

<h1>JWT Test Dashboard</h1>

<div class="container">

    <div class="card">
        <h2>Login</h2>
        <input type="email" id="email" placeholder="Email">
        <input type="password" id="password" placeholder="Password">
        <button onclick="login()">Login</button>
    </div>

    <div class="card actions">
        <h2>Actions</h2>
        <button onclick="checkMe()">Check /me</button>
        <button onclick="logout()">Logout</button>
    </div>

    <div class="card">
        <h2>Stations</h2>
        <input type="text" id="identifier" placeholder="Identifier">
        <input type="number" id="queryID" placeholder="Query ID">
        <button onclick="getStations()">Get Stations</button>
    </div>

    <div class="card">
        <h2>Token</h2>
        <pre id="tokenOut"></pre>
    </div>

    <div class="card">
        <h2>Decoded JWT</h2>
        <pre id="decodedOut"></pre>
    </div>

    <div class="card full-width">
        <h2>Response</h2>
        <pre id="output"></pre>
    </div>

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

        print({ endpoint: "/me", status: res.status, response: data });

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

        print({ endpoint: "/logout", status: res.status, response: data });
    }

    async function getStations() {
        const token = getToken();

        if (!token) {
            print({ error: "No token found" });
            return;
        }

        const identifier = document.getElementById("identifier").value;
        const queryID = document.getElementById("queryID").value;

        const url = `${API_BASE}/${identifier}/${queryID}/stations`;

        const res = await fetch(url, {
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

        print({ endpoint: url, status: res.status, response: data });

        if (res.status === 401) {
            clearAuth();
        }
    }
</script>

</body>
</html>
