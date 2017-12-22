'use strict';

var _vue = require('vue');

var _vue2 = _interopRequireDefault(_vue);

var _veeValidate = require('vee-validate');

var _veeValidate2 = _interopRequireDefault(_veeValidate);

var _vueNumeric = require('vue-numeric');

var _vueNumeric2 = _interopRequireDefault(_vueNumeric);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// window.Multiselect =require('vue-multiselect');
// window.modelSelect = require('vue-search-select');
// window.VueNumeric=require('vue-numeric');
// var VueNumeric = require('vue-numeric');
// var VeeValidate= require('vee-validate');
// Vue.use(require(VeeValidate));
// Vue.use(VueNumeric.default);
// Vue.use(require('vue2-filters'));
// Vue.component('vue-numeric',VueNumeric.default);
// Vue.component('multiselect',Multiselect.Multiselect);

// import Multiselect from 'vue-multiselect';

window.Vue = _vue2.default;
window.ErrorBag = _veeValidate.ErrorBag;
_vue2.default.use(_veeValidate2.default);
// Component
_vue2.default.component('vue-numeric', _vueNumeric2.default);
// Vue.component('multiselect',Multiselect);
_vue2.default.component('example-component', require('./components/ExampleComponent.vue'));
_vue2.default.component('materials-items-create', require('./components/materials/items/CreateComponent.vue'));
//# sourceMappingURL=app.js.map