/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
//Core Libraries
import Vue from 'vue';
import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import {ErrorBag} from 'vee-validate';
import Multiselect from 'vue-multiselect';
import VueNumeric from 'vue-numeric';
import VModal from 'vue-js-modal';
import loading from 'vue-full-loading';
import Datepicker from 'vuejs-datepicker';
import VueMoment from 'vue-moment';
import {Auth} from './services/auth';
import Vue2Filters from 'vue2-filters';
import VuejsDialog from 'vuejs-dialog';
import Cleave from 'vue-cleave-component';
//After Use Vue Component Build Web
import {router} from "./routes";
import VueBreadcrumbs from 'vue-breadcrumbs';
//Global Method
Vue.mixin(Auth);
window.Vue = Vue;
window.ErrorBag = ErrorBag;
//Global Plugin
Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VModal);
Vue.use(VueMoment);
Vue.use(Vue2Filters);
Vue.use(VuejsDialog,{
    html: true,
    okText: 'ยืนยัน',
    cancelText: 'ยกเลิก',
});
Vue.use(VueBreadcrumbs,require('../js/components/Breadcrumbs'));
// Global Component
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('vue-numeric', VueNumeric);
Vue.component('multiselect', Multiselect);
Vue.component('loading', loading);
Vue.component('datepicker', Datepicker);
Vue.component('cleave',Cleave);
Vue.component('app-table',require('./components/Table.vue'));

new Vue({
    el:'#my-root-vue',
    router // router for vue components
});