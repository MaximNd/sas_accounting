
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import { store } from './store/store';
import VueAuth from '@websanova/vue-auth';
import Vuetify from 'vuetify';
import VueAxios from 'vue-axios';
import VeeValidate from 'vee-validate';
import { VueHammer } from 'vue2-hammer';
import axios from 'axios';
import 'vuetify/dist/vuetify.min.css'

axios.defaults.baseURL = process.env.MIX_API_BASE_URL;
import router from './router';

Vue.router = router;
Vue.use(VueAxios, axios)
Vue.use(Vuetify);
Vue.use(VeeValidate);
Vue.use(VueHammer);

Vue.use(VueAuth, {
    rolesVar: 'role',
    tokenDefaultName: 'sas_accounting_auth_token',
    parseUserData: data => data || {},
    auth: {
        request: function (req, token) {
            this.options.http._setHeaders.call(this, req, {Authorization: 'Bearer ' + token});
        },
        response: function (res) {
            return res.data.access_token;
        }
    },
    http: require('@websanova/vue-auth/drivers/http/axios.1.x'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x'),
    loginData: { url: `${process.env.MIX_APP_BASE_URL}oauth/token`, method: 'POST', redirect: '/', fetchUser: true },
    // registerData: { url: `${Vue.http.options.root}/user/signup`, method: 'POST', redirect: '/login', fetchUser: false },
    refreshData: { url: 'auth/refresh', method: 'GET', enabled: false, interval: 0 },
    fetchData: { url: 'user', method: 'GET', enabled: true }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app', require('./App.vue'));

const app = new Vue({
    el: '#app',
    router,
    store,
    template: '<app/>'
});
