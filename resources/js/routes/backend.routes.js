import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import Dashboard from './../components/backend/Dashboard';
import Profile from './../components/backend/Profile';

const routes = [
    {
        name: 'dashboard',
        path: '/backoffice/dashboard',
        component: Dashboard,
        meta: {
            title: 'Dashbor | Admin area'
        }
    },
    {
        name: 'profile',
        path: '/backoffice/profile',
        component: Profile,
        meta: {
            title: 'Profil | Admin area'
        }
    }
];

export default new Router({
    mode: 'history',
    routes
});
