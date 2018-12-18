/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import DatePicker from "vuejs-datepicker";

import { nl } from "vuejs-datepicker/dist/locale";

window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("date-picker", DatePicker);
Vue.component('product-card-timer', require('./components/ProductCardTimer.vue'));

const app = new Vue({
    el: "#app",
    data: () => {
        return {
            lang: {
                nl
            }
        };
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
