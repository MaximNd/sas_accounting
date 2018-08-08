import Vue from 'vue'
import Router from 'vue-router'

import Login from './../containers/auth/login/Login.vue';
import ForgotPassword from './../containers/auth/reset/ForgotPassword.vue';
import ResetPassword from './../containers/auth/reset/ResetPassword.vue';
import Profile from './../containers/profile/Profile.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/password/forgot',
        name: 'forgot-password',
        component: ForgotPassword
    },
    {
        path: '/password/reset/:token',
        name: 'reset-password',
        component: ResetPassword
    },
    {
        path: '/profile/:id',
        name: 'profile',
        component: Profile
    },
    {
        path: '',
        name: 'home',
        beforeEnter: function() {
            if (typeof Vue.auth.user().role === 'undefined') {
                Vue.router.push('/login');
                return;
            } else {
                Vue.router.replace(`/profile/${Vue.auth.user().id}`);
                return;
            }
        }
      }
  ]
});
