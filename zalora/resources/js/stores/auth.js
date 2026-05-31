import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
    const token = ref(localStorage.getItem('jwt_token') || null)
    const user  = ref(null)

    const isAuthenticated = computed(() => !!token.value)

    function setToken(t) {
        token.value = t
        localStorage.setItem('jwt_token', t)
        axios.defaults.headers.common['Authorization'] = `Bearer ${t}`
    }

    function clearToken() {
        token.value = null
        user.value  = null
        localStorage.removeItem('jwt_token')
        delete axios.defaults.headers.common['Authorization']
    }

    async function login(email, password) {
        const { data } = await axios.post('/api/login', { email, password })
        setToken(data.token)
        user.value = data.user
        return data
    }

    async function logout() {
        await axios.post('/api/logout')
        clearToken()
    }

    async function fetchUser() {
        if (!token.value) return
        axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
        const { data } = await axios.get('/api/me')
        user.value = data
    }

    return { token, user, isAuthenticated, login, logout, fetchUser }
})
