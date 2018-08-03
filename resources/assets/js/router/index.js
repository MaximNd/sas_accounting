import Vue from 'vue'
import Router from 'vue-router'

import Login from './../containers/auth/login/Login.vue';
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
