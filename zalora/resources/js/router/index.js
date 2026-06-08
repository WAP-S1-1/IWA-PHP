import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import DashboardView from "../../views/DashboardView.vue";
import LoginForm from "../../views/components/LoginForm.vue";
import HomeView from '../../views/HomeView.vue';
import MapView from '../../views/MapView.vue';
import UserAdministration from "../../views/components/UserAdministration.vue";

const routes = [
    { path: '/login', component: LoginForm },
    { path: '/dashboard', component: DashboardView, meta: { requiresAuth: true } },
    { path: '/home', component: HomeView, meta: { requiresAuth: true } },
    { path: '/', redirect: '/home' },
    { path: '/map', component: MapView, meta: { requiresAuth: true } },
    { path: '/users', component: UserAdministration, meta: { requiresAuth: true } }
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
