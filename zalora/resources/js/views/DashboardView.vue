<template>
    <div class="min-h-screen flex items-center justify-center">
        <div>
            <h1 class="text-2xl font-semibold">Welcome, {{ auth.user?.name }}</h1>
            <button @click="handleLogout" class="mt-4 text-sm text-gray-500 hover:text-gray-900">
                Sign out
            </button>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth   = useAuthStore()
const router = useRouter()

async function handleLogout() {
    await auth.logout()
    router.push('/login')
}
</script>
