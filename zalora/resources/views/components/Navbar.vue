<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
import logo from '../../../public/zalora_logo.png'

const auth   = useAuthStore()
const router = useRouter()
const menuOpen = ref(false)

async function handleLogout() {
    await auth.logout()
    router.push('/login')
}
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
            <router-link to="/users">Users</router-link>
            <a href="#" @click.prevent="handleLogout">Logout</a>

        </nav>
    </header>
</template>
<style scoped>
@import '../../css/navbar.css';
</style>
