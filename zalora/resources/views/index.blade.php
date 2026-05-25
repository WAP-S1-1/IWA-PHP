<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <title>Home</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #f5f7fb;
            --text: #1f2937;
            --primary: #111827;
            --secondary: #6366f1;
            --white: #ffffff;
            --border: #e5e7eb;
        }

        body {
            font-family: Arial, sans-serif;
            background: white;
            color: black;
            line-height: 1.6;
        }

        button {
            cursor: pointer;
            border: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            position: sticky;
            top: 0;

            background: black;
            border-bottom: 1px solid var(--border);

            padding: 1rem;
            z-index: 100;
        }

        .title {
            font-size: 1.25rem;
            font-weight: bold;
            color: white;
        }

        .menu-btn {
            font-size: 1.5rem;
            color: white;
            background: none;
        }

        .nav {
            display: none;

            position: absolute;
            top: 70px;
            left: 0;

            width: 100%;
        }

        .nav.show {
            display: flex;
            flex-direction: column;
            background: black;
            align-content: center;
        }

        .nav a {
            padding: 1rem;
            text-decoration: none;
            color: white;
            border-top: 1px solid var(--border);
        }

        /* TABLET */
        @media (min-width: 768px) {
            .menu-btn {
                display: none;
            }

            .nav {
                display: flex;
                position: static;
                flex-direction: row;
                width: auto;
                border: none;
                gap: 1rem;
            }

            .nav.show {
                display: flex;
                flex-direction: row;
            }

            .nav a {
                border: none;
                padding: 0;
            }
        }

        /* DESKTOP */
        @media (min-width: 1024px) {
            .menu-btn {
                display: none;
            }

            .nav {
                display: flex;
                position: static;
                flex-direction: row;
                width: auto;
                border: none;
                gap: 1rem;
            }

            .nav.show {
                display: flex;
                flex-direction: row;
            }

            .nav a {
                border: none;
                padding: 0;
            }
        }

    </style>
</head>
<body>

<div id="app">

    <header class="header">

        <div class="title">
            Zalora
        </div>

        <button
            class="menu-btn"
            @click="menuOpen = !menuOpen"
        >
            ☰
        </button>

        <nav
            class="nav"
            :class="{ show: menuOpen }"
        >
            <a href="#">Home</a>
            <a href="#">Login</a>
        </nav>

    </header>

</div>

<script>
    const { createApp } = Vue

    createApp({

        data() {
            return {
                menuOpen: false,
            }
        }

    }).mount('#app')
</script>
</body>
</html>
