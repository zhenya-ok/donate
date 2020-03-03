import Vue from 'vue';
import VueRouter from 'vue-router';

const Dashboard = () => import('./components/Dashboard.vue');
const Main = () => import('./components/Main.vue');
const Success = () => import('./components/Success.vue');

Vue.use(VueRouter);

export const routes = [
    { path: '/', name: 'main', component: Main, props: (route) => ({}) },
    { path: '/dashboard', name: 'dashboard.index', component: Dashboard, props: (route) => ({}) },
    { path: '/success', name: 'success', component: Success, props: (route) => ({}) },
];

export const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;