import Vue from 'vue'
import Router from 'vue-router'

import Login from './../containers/auth/login/Login.vue';
import ForgotPassword from './../containers/auth/reset/ForgotPassword.vue';
import ResetPassword from './../containers/auth/reset/ResetPassword.vue';
import Profile from './../containers/profile/Profile.vue';
import Users from './../containers/users/Users.vue';
import Clients from './../containers/clients/Clients.vue';
import Client from './../containers/clients/client/Client.vue';
import PriceList from './../containers/priceList/PriceList.vue';
import CreateOrder from './../containers/createOrder/CreateOrder.vue';
import Orders from './../containers/orders/Orders.vue';
import Order from './../containers/order/Order.vue';
import PriceListHistory from './../containers/priceListHistory/PriceListHistory.vue';
import OrdersHistory from './../containers/ordersHistory/OrdersHistory.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/password/forgot',
        name: 'forgot-password',
        component: ForgotPassword,
        meta: {
            auth: false
        }
    },
    {
        path: '/password/reset/:token',
        name: 'reset-password',
        component: ResetPassword,
        meta: {
            auth: false
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta: {
            auth: true
        }
    },
    {
        path: '/users',
        name: 'users',
        component: Users,
        meta: {
            auth: true
        }
    },
    {
        path: '/clients',
        name: 'clients',
        component: Clients,
        meta: {
            auth: true
        }
    },
    {
        path: '/clients/:id',
        name: 'client',
        component: Client,
        meta: {
            auth: true
        }
    },
    {
        path: '/price-list',
        name: 'price-list',
        component: PriceList,
        meta: {
            auth: true
        }
    },
    {
        path: '/create-order',
        name: 'create-order',
        component: CreateOrder,
        meta: {
            auth: true
        }
    },
    {
        path: '/orders',
        name: 'orders',
        component: Orders,
        meta: {
            auth: true
        }
    },
    {
        path: '/orders/:id',
        name: 'order',
        component: Order,
        meta: {
            auth: true
        }
    },
    {
        path: '/price-list-history',
        name: 'price-list-history',
        component: PriceListHistory,
        meta: {
            auth: true
        }
    },
    {
        path: '/orders-history',
        name: 'orders-history',
        component: OrdersHistory,
        meta: {
            auth: true
        }
    },
    {
        path: '',
        name: 'home',
        beforeEnter: function() {
            if (typeof Vue.auth.user().role === 'undefined') {
                Vue.router.push('/login');
                return;
            } else {
                Vue.router.replace('/profile');
                return;
            }
        }
      }
  ]
});
