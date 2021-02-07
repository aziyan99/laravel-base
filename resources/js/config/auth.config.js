let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Vue from 'vue';
import { Form, HasError, AlertError } from 'vform';
import Toasted from 'vue-toasted';

window.Fire = new Vue();
window.Form = Form;
window.RESTURIV1 = '/api/v1';

const toastedOptions = {
    position: "top-center",
	duration : 3000
};

Vue.use(Toasted, toastedOptions)

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
