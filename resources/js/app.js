require('./bootstrap');

import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Loading from 'vue-loading-overlay';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.use(VueAxios, axios);
Vue.use(VueToast);
Vue.use(Loading);

Vue.component('p-register', require('./pages/RegisterPage').default);
Vue.component('p-login', require('./pages/LoginPage').default);

Vue.component('p-profits-create', require('./pages/profits/create').default);
Vue.component('p-expenses-create', require('./pages/expenses/create').default);
Vue.component('p-groups-create', require('./pages/groups/create').default);
Vue.component('p-categories-create', require('./pages/categories/create').default);

const app = new Vue({
    el: "#app"
})
