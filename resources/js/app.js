
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
require('bootstrap-timepicker/js/bootstrap-timepicker.js');
require('glyphicons/glyphicons.js');
require('./../a-seat-plan/jquery.seat-charts.min.js');



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });
