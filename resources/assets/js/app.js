
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import {ErrorBag} from 'vee-validate';
import Multiselect from 'vue-multiselect';
import VueNumeric from 'vue-numeric';
import VModal from 'vue-js-modal';

window.Vue=Vue;
window.VueRouter=VueRouter;
window.ErrorBag=ErrorBag;
Vue.use(VeeValidate);
Vue.use(VModal);

// Component
Vue.component('vue-numeric',VueNumeric);
Vue.component('multiselect',Multiselect);
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('materials-items-create',require('./components/materials/items/CreateComponent.vue'));