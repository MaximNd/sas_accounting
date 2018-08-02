import Vue from 'vue'
import Router from 'vue-router'

import Login from './../containers/auth/login/Login.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '',
        name: 'home',
        beforeEnter: function() {
          if (typeof Vue.auth.user().role === 'undefined') {
            Vue.router.push('/login'); return;
          } else {
            // TODO
            // Vue.router.push(`/profile/${Vue.auth.user()._id}`); return;
          }
        }
      }
  ]
});
