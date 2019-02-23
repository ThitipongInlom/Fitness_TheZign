require('./bootstrap');
require('fortawesome/fontawesome-free/js/all.js');
require('jquery.redirect');
// datepicker
require('air-datepicker/dist/js/datepicker');
require('air-datepicker/dist/js/i18n/datepicker.en');
// Sweetalert2
window.swal = require('sweetalert2');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue'));
