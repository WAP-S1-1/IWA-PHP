<script setup>
import { ref } from 'vue'

const menuOpen = ref(false)
</script>

<template>
    <header class="header">
        <h1>Zalora</h1>
        <button class="menu-btn"
        @click="menuOpen = !menuOpen">
            ☰
        </button>
        <nav class="nav"
        :class="{ show: menuOpen}">
            <a href="/home">Home</a>
            <a href="/map">Show Map</a>
            <a href="/logout">Logout</a>
        </nav>
    </header>
</template>

<style scoped>
.header {
    height: 80px;
    display: flex;
    justify-content: space-between;
    align-items: center;

    position: sticky;
    top: 0;

    background: black;
    color: white;

    padding: 1rem;
    z-index: 100;
}

h1 {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 0;
    line-height: 0;
}

.menu-btn {
    font-size: 2rem;
    background: none;
    color: white;
    border: none;
}

.nav {
    display: none;

    position: absolute;
    top: 80px;
    left: 0;

    width: 100%;
}

.nav.show {
    display: flex;
    flex-direction: column;
    border-top: 1px solid white;
}

.nav a {
    font-size: 1.5rem;
    padding: 1rem;
    text-decoration: none;
    background: black;
    color: white;
    border-bottom: 1px solid white;
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

    .nav a:not(:last-child) {
        border-right: 2px solid white;
        padding-right: 1rem;
    }

    .nav a {
        border: none;
        padding: 0;
    }
}
</style>
