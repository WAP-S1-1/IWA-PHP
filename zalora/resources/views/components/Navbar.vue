<script setup>
import { ref } from 'vue'
import logo from '../../../public/zalora_logo.png'

const menuOpen = ref(false)
</script>

<template>
    <header class="header">
        <a href="/home">
            <img :src="logo" alt="Logo" width="246" height="41">
        </a>
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
@import '../../css/navbar.css';
</style>
