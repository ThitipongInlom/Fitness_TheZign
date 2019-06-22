
window._ = require('lodash');
window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');
    // Admin Lte
    require('admin-lte');
    // Bootstrap
    require('bootstrap');
    // Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        "html": true,
    });
    $("[data-toggle='tooltip']").tooltip({
        "html": true,
    });
    // Data Table
    require( 'datatables.net-bs4' )();
    require( 'datatables.net-buttons-bs4' )();
    require( 'datatables.net-colreorder-bs4' )();
    require( 'datatables.net-fixedcolumns-bs4' )();
    require( 'datatables.net-fixedheader-bs4' )();
    require( 'datatables.net-responsive-bs4' )();
    require( 'datatables.net-rowgroup-bs4' )();
    require( 'datatables.net-scroller-bs4' )();
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
