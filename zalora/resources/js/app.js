import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App    from './App.vue'
import router from './router'
import { useAuthStore } from '@/stores/auth'
import '../css/app.css'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)

useAuthStore() // ← forces store init + sets axios header before routing

app.use(router)
app.mount('#app')
