<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-xl p-10 shadow-sm">
            <h1 class="text-2xl font-semibold text-gray-900 mb-1">myapp</h1>
            <p class="text-sm text-gray-500 mb-6">Sign in to continue</p>

            <div v-if="error" class="text-sm text-red-600 bg-red-50 rounded-lg px-4 py-3 mb-4">
                {{ error }}
            </div>

            <div v-if="result" class="text-xs bg-gray-100 rounded-lg px-4 py-3 mb-4">
                <p class="font-medium text-gray-500 mb-1">Auth test result:</p>
                <pre>{{ result }}</pre>
            </div>

            <form @submit.prevent="handleLogin" class="space-y-4">
                <div>
                    <label class="block text-xs font-medium uppercase tracking-wide text-gray-500 mb-1.5">
                        Email
                    </label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        placeholder="you@example.com"
                        class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <div>
                    <label class="block text-xs font-medium uppercase tracking-wide text-gray-500 mb-1.5">
                        Password
                    </label>
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        placeholder="••••••••"
                        class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors mt-2"
                >
                    {{ loading ? 'Signing in…' : 'Sign in' }}
                </button>
            </form>

            <button
                @click="testAuth"
                class="w-full mt-3 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-500 transition-colors"
            >
                Test Auth
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'

const router  = useRouter()
const auth    = useAuthStore()
const loading = ref(false)
const error   = ref(null)
const result  = ref(null)

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

async function testAuth() {
    result.value = null
    try {
        const { data } = await axios.get('/api/me')
        result.value = JSON.stringify(data, null, 2)
    } catch (err) {
        result.value = JSON.stringify(err.response?.data, null, 2)
    }
}
</script>
