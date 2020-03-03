// assets/js/app.js
import Vue from 'vue';
import routes from './routes';
import AppView from './components/App.vue';
import BootstrapVue from 'bootstrap-vue';
import VueResource from 'vue-resource';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);
Vue.use(VueResource);

// Создаём и монтируем корневой экземпляр Vue нашего приложения.
const appDashboard = new Vue({
    el: '#vue-dashboard-app',
    router: routes,
    render: h => h(AppView)
});
