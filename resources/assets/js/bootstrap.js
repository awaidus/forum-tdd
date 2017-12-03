window._ = require('lodash');


window.Vue = require('vue');

let authorizations = require('./authorizations');

Vue.prototype.authorize = function (...params) {

    if (!window.App.signedIn) return false;

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
};

Vue.prototype.signedIn = window.App.signedIn;


try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {
}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.events = new Vue();

//Register a global event for flash component
window.flash = function (message, level = 'success') {
    window.events.$emit('flash', {message, level});
};