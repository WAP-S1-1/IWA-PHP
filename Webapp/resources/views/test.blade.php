<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Login Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        pre {
            background: #111;
            color: #0f0;
            padding: 10px;
            overflow: auto;
        }
    </style>
</head>
<body>

<h2>Customer Login Test</h2>

<input type="email" id="email" placeholder="Email">
<input type="password" id="password" placeholder="Password">

<button onclick="login()">Login</button>

<h3>Token</h3>
<pre id="tokenOut"></pre>

<h3>Decoded JWT Payload</h3>
<pre id="decodedOut"></pre>

<h3>API Response</h3>
<pre id="responseOut"></pre>

<script>
    function parseJwt(token) {
        try {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        } catch (e) {
            return { error: "Invalid token" };
        }
    }

    async function login() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const responseOut = document.getElementById('responseOut');
        const tokenOut = document.getElementById('tokenOut');
        const decodedOut = document.getElementById('decodedOut');

        try {
            const response = await fetch('IWA/contracten/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email,
                    password
                })
            });

            const data = await response.json();

            responseOut.textContent = JSON.stringify(data, null, 2);

            if (data.token) {
                // store token
                localStorage.setItem('token', data.token);

                // show raw token
                tokenOut.textContent = data.token;

                // decode JWT
                const decoded = parseJwt(data.token);
                decodedOut.textContent = JSON.stringify(decoded, null, 2);
            }

        } catch (error) {
            responseOut.textContent = 'Error: ' + error.message;
        }
    }
</script>

</body>
</html>
