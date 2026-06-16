import { createApp } from 'vue'
import { createPinia } from 'pinia'
import {useAuthStore} from "./stores/auth.js";
import router from "./router/index.js";
import App from "./app.vue";
 // import LoginForm from './Components/LoginForm.vue'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)

useAuthStore() // ← forces store init + sets axios header before routing

app.use(router)
app.mount('#app')
