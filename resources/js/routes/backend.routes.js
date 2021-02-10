import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import Dashboard from './../components/backend/Dashboard';
import Profile from './../components/backend/Profile';
import Role from './../components/backend/Role';
import Permission from './../components/backend/Permission';
import AssignPermission from './../components/backend/AssignPermission';
import User from './../components/backend/User';


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
        name: 'assignpermission',
        path: '/backoffice/assignpermission',
        component: AssignPermission,
        meta: {
            title: 'Assign Permission | Admin area'
        }
    },
    {
        name: 'user',
        path: '/backoffice/user',
        component: User,
        meta: {
            title: 'Pengguna | Admin area'
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
