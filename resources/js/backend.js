require('./bootstrap');
window.Vue = require('vue').default;
import router from './routes/backend.routes';
import Permissions from './mixins/Permissions';

Vue.mixin(Permissions);

require('./config/backend.config');

Vue.component('backend', require('./components/layouts/Backend').default);

const app = new Vue({
    el: '#app',
    router
});
