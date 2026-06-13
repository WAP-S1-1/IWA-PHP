import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Home from '../../views/Home.vue';
import ShowMap from '../../views/ShowMap.vue';
import ShowTemperature from "../../views/ShowTemperature.vue";
import DashboardView from "../../views/DashboardView.vue";
import LoginForm from "../../views/LoginForm.vue";

const routes = [
    { path: '/login', component: LoginForm },
    { path: '/dashboard', component: DashboardView, meta: { requiresAuth: true } },
    { path: '/home', component: HomeView, meta: { requiresAuth: true } },
    { path: '/', redirect: '/home' },
    { path: '/map', component: ShowMap, meta: { requiresAuth: true } },
    { path: '/temperature', component: ShowTemperature, meta: { requiresAuth: true } },
    { path: '/users', component: UserAdministration, meta: { requiresAuth: true, roles: ['admin', 'staff'] } }
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

    if (to.meta.roles && !to.meta.roles.includes(auth.user?.role)) {
        return '/home'
    }
})

export default router
