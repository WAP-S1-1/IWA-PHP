<script setup>
import { ref } from 'vue'
import logo from '../../../public/zalora_logo.png'

const menuOpen = ref(false)
</script>

<template>
    <header class="header">
        <router-link to="/">
            <img :src="logo" alt="Logo" width="246" height="41">
        </router-link>
        <button class="menu-btn"
        @click="menuOpen = !menuOpen">
            ☰
        </button>
        <nav class="nav"
        :class="{ show: menuOpen}">
            <router-link to="/">Home</router-link>
            <router-link to="/map">Map</router-link>
            <router-link to="/logout">Logout</router-link>
        </nav>
    </header>
</template>
<style scoped>
@import '../../css/navbar.css';
</style>
