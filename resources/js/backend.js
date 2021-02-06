require('./bootstrap');

window.Vue = require('vue').default;

require('./config/backend.config');


const app = new Vue({
    el: '#app',
});
