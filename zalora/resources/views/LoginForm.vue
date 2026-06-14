<template>
    <div class="wrapper">
        <img :src="logo" alt="Logo" >
        <div id="Form-outer-div">
            <div id="Form-div">
                <form @submit.prevent="handleLogin" id="submitform">
                    <h3 id="Zalora-titel2">Login</h3>

                    <div v-if="error" style="color: red; font-size: 0.85rem; margin-bottom: 8px;">{{ error }}</div>

                    <input v-model="form.email" id="email" type="text" placeholder="email" required><br>
                    <input v-model="form.password" id="password" type="password" placeholder="Password" required><br>

                    <button id="submit" type="submit" :disabled="loading" style="font-size: small">
                        {{ loading ? 'Logging in…' : 'Login' }}
                    </button>

                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import logo from "../../public/zalora_logo_black.png";

const router  = useRouter()
const auth    = useAuthStore()
const loading = ref(false)
const error   = ref(null)

const form = ref({ email: '', password: '' })

async function handleLogin() {
    loading.value = true
    error.value   = null
    try {
        await auth.login(form.value.email, form.value.password)
        router.push('/home')
    } catch (err) {
        error.value = err.response?.data?.message ?? 'Something went wrong.'
    } finally {
        loading.value = false
    }
}
</script>

<style scoped>
@import '../css/login.css';
</style>
