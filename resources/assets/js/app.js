require('./bootstrap');
require('fontawesome-free/js/all.js');
require('jquery.redirect');
// datepicker
require('air-datepicker');
// Sweetalert2
window.swal = require('sweetalert2');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue'));
