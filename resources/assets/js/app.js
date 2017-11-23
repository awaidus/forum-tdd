window.Vue = require('vue');

require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('reply', require('./components/Reply.vue'));

Vue.component('thread-view', require('./pages/Thread.vue'));

const app = new Vue({
    el: '#app'
});
