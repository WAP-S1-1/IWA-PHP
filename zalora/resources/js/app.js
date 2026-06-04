import { createApp } from 'vue'
import {useAuthStore} from "./stores/auth.js";
import router from "./router/index.js";
import app from "./app.vue";
 // import LoginForm from './Components/LoginForm.vue'

app.use(pinia)

useAuthStore() // ← forces store init + sets axios header before routing

app.use(router)
app.mount('#app')
