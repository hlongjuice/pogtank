/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
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

//Global Method
Vue.mixin(Auth);
window.Vue = Vue;
window.VueRouter = VueRouter;
window.ErrorBag = ErrorBag;
Vue.use(VeeValidate);
Vue.use(VModal);
Vue.use(VueMoment);

// Component
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('vue-numeric', VueNumeric);
Vue.component('multiselect', Multiselect);
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('materials-items-create', require('./components/materials/items/CreateComponent.vue'));
Vue.component('loading', loading);
Vue.component('datepicker', Datepicker);