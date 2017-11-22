
window.Vue = require('vue');

require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue'));

const app = new Vue({
    el: '#app'
});
