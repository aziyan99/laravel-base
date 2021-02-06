import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import Login from './../components/auth/Login';

const routes = [
    {
        name: 'login',
        path: '/auth/login',
        component: Login,
        meta: {
            title: 'Login | Admin area'
        }
    }
];

export default new Router({
    mode: 'history',
    routes
});
