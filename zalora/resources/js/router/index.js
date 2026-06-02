import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import LoginView    from '@/views/LoginView.vue'
import DashboardView from '@/views/DashboardView.vue'
import LoginForm from "../Components/LoginForm.vue"
import Home from '../../views/Home.vue';
import ShowMap from '../../views/ShowMap.vue';

const routes = [
    { path: '/login', component: LoginForm },
    { path: '/dashboard', component: DashboardView, meta: { requiresAuth: true } },
    { path: '/home', component: Home, meta: { requiresAuth: true }},
    { path: '/', redirect: '/home' },
    { path: '/map', component: ShowMap, meta: { requiresAuth: true } },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to) => {
    const auth = useAuthStore()
    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        return '/login'
    }
})

export default router
