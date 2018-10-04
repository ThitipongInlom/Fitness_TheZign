require('./bootstrap');
require('fontawesome-free/js/all.js');
require('jquery.redirect');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue'));
