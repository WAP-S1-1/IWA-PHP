<template>
    <header class="header">
        <h1>Zalora</h1>
        <button class="menu-btn"
        @click="menuOpen = !menuOpen">
            ☰
        </button>
        <nav class="nav"
        :class="{ show: menuOpen}">
            <a href="#">Home</a>
            <a href="#">Login</a>
        </nav>
    </header>
</template>
<script setup>
import { ref } from 'vue'

const menuOpen = ref(false)
</script>
<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 1rem;
    background: white;
}

.menu-btn {
    font-size: 1.5rem;
    border: none;
    background: none;
}

.nav {
    display: none;

    position: absolute;
    top: 60px;
    left: 0;

    width: 100%;
    background: white;

    flex-direction: column;
}

.nav.show {
    display: flex;
}

.nav a {
    padding: 1rem;
    text-decoration: none;
    color: black;
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
        gap: 1rem;
    }
}
</style>
