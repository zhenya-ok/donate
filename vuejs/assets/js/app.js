import Vue from 'vue';
import routes from './routes';
import AppView from './components/App.vue';
import BootstrapVue from 'bootstrap-vue';
import VueResource from 'vue-resource';
// import VueFormGenerator from 'vue-form-generator'
// import 'vue-form-generator/dist/vfg.css'

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);
Vue.use(VueResource);
// Vue.use(VueFormGenerator)

Vue.config.productionTip = true;

// Создаём и монтируем корневой экземпляр Vue нашего приложения.
const app = new Vue({
    el: '#vue-app',
    router: routes,
    render: h => h(AppView)
});

