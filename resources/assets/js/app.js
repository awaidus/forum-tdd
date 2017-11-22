
window.Vue = require('vue');

require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('reply', require('./components/Reply.vue'));

const app = new Vue({
    el: '#app'
});
