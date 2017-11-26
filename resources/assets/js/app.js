window.Vue = require('vue');

require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('thread-view', require('./pages/Thread.vue'));
Vue.component('user-notifications', require('./components/UserNotifications.vue'));

const app = new Vue({
    el: '#app'
});
