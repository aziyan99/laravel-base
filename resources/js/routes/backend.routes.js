import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import Dashboard from './../components/backend/Dashboard';
import Profile from './../components/backend/Profile';
import Role from './../components/backend/Role';
import Permission from './../components/backend/Permission';

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
        name: 'role',
        path: '/backoffice/role',
        component: Role,
        meta: {
            title: 'Role | Admin area'
        }
    },
    {
        name: 'permission',
        path: '/backoffice/permission',
        component: Permission,
        meta: {
            title: 'Permission | Admin area'
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
