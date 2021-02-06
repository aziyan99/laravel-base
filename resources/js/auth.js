require('./bootstrap');
window.Vue = require('vue').default;
import router from './routes/auth.routes';

require('./config/auth.config');

Vue.component('auth', require('./components/layouts/Auth').default);

const app = new Vue({
    el: '#app',
    router
});
