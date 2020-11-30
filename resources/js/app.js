require('./bootstrap');

import Vue from 'vue/dist/vue.min.js';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import {routes} from "./routes";
const router = new VueRouter({
    routes ,
    // mode:'history',
    mode:'hash',
});
Vue.component('sidebar', require('./components/layouts/sidebar').default);
Vue.component('nav-top', require('./components/layouts/nav').default);
Vue.component('footer-bottom', require('./components/layouts/footer').default);
Vue.component('sidebar-filter', require('./components/layouts/filters').default);

//import helper user class
import User from './helper/User';
Window.User = User;

Vue.config.devtools = true;
const app = new Vue({
    el: '#app',
    router
});
