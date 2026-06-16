<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-xl p-10 shadow-sm">
            <h1 class="text-2xl font-semibold text-gray-900 mb-1">myapp</h1>
            <p class="text-sm text-gray-500 mb-6">Welcome, {{ auth.user?.name }}</p>

            <div v-if="result" class="text-xs bg-gray-100 rounded-lg px-4 py-3 mb-4">
                <p class="font-medium text-gray-500 mb-1">Auth test result:</p>
                <pre>{{ result }}</pre>
            </div>

            <button
                @click="testAuth"
                class="w-full py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-500 transition-colors"
            >
                Test Auth
            </button>

            <button
                @click="handleLogout"
                class="w-full mt-3 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors"
            >
                Sign out
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth   = useAuthStore()
const router = useRouter()
const result = ref(null)

async function testAuth() {
    try {
        const { data } = await axios.get('/api/weather', {
            params: {
                datetime: new Date().toISOString(),
                interval: 'hour'
            }
        })

        result.value = JSON.stringify(data, null, 2)
    } catch (err) {
        result.value = JSON.stringify(err.response?.data, null, 2)
    }
}

async function handleLogout() {
    await auth.logout()
    router.push('/login')
}
</script>
