import axios from "axios"
import { useAuthStore } from "./auth.js";
import config from "bootstrap/js/src/util/config.js";

const api = axios.create({
    baseURL: 'http://localhost:8000/api'
})

api.interceptors.request.use((config) => {
    const auth = useAuthStore()

    if (auth.token) {
        config.headers.Authorization = `Bearer ${auth.token}`
    }

    return config
})

export default api
