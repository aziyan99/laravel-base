let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


import Vue from 'vue';
import { Form, HasError, AlertError } from 'vform';
import Toasted from 'vue-toasted';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import { VclTable, VclFacebook } from 'vue-content-loading';

window.Fire = new Vue();
window.Form = Form;
window.RESTURIV1 = '/api/v1';

const toastedOptions = {
    position: "top-center",
	duration : 3000
};

Vue.use(Toasted, toastedOptions);
Vue.use(VueProgressBar, {
    color: '#3D53C6',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
});
Vue.filter('formatDate', function (createdAt) {
    moment.locale('id');
    return moment(createdAt).format('dddd');
});

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('table-loading', VclTable);
Vue.component('facebook-loading', VclFacebook);

