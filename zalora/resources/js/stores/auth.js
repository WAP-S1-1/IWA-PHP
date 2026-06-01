import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
    const token = ref(localStorage.getItem('jwt_token') || null)
    if (token.value) {
        console.log('Setting axios header:', token.value)  // ← add this
        axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
    }
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
        const { data } = await axios.post('/api/user_login', { email, password })
        setToken(data.token)
        user.value = data.user
        return data
    }

    async function logout() {
        await axios.post('/api/user_logout')
        clearToken()
    }

    async function fetchUser() {
        if (!token.value) return
        const { data } = await axios.get('/api/user_me')
        user.value = data
    }

    return { token, user, isAuthenticated, login, logout, fetchUser }
})
