/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 205);
/******/ })
/************************************************************************/
/******/ ({

/***/ 205:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(206);


/***/ }),

/***/ 206:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_order_service__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_webUrl__ = __webpack_require__(3);


var webUrl = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_webUrl__["a" /* default */]();
var projectOderService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_order_service__["a" /* default */]();
new Vue({
    el: '#project-order-index',
    data: {
        showLoading: '',
        orders: {}
    },
    mounted: function mounted() {
        this.showLoading = true;
        this.initialData();
    },
    methods: {
        initialData: function initialData() {
            var _this = this;

            Promise.all([
            //Get All Project Orders
            projectOderService.getAllProjectOrders().then(function (result) {
                _this.orders = result;
            }).catch(function (err) {
                alert(err);
            })]).then(function () {
                _this.showLoading = false;
            }).catch();
        },
        getSelectedProductPage: function getSelectedProductPage() {},

        //Open Porlor 4
        openPorlor4Page: function openPorlor4Page(order) {
            window.location = webUrl.getRoute('/admin/project_order/' + order.id + '/porlor_4');
        }
    }
});

/***/ }),

/***/ 3:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var WebUrl = function () {
    function WebUrl()
    // private url:string
    {
        _classCallCheck(this, WebUrl);

        // this.url='http://localhost:3000/pogtank/public';
        // this.url='http://localhost/pogtank/public';
        this.url = '';
    }

    _createClass(WebUrl, [{
        key: 'getUrl',
        value: function getUrl() {
            return this.url;
        }
    }, {
        key: 'getRoute',
        value: function getRoute(url) {
            return this.url + url;
        }
    }]);

    return WebUrl;
}();

/* harmony default export */ __webpack_exports__["a"] = (WebUrl);

/***/ }),

/***/ 39:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(3);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var ProjectOrderService = function () {
    function ProjectOrderService() {
        _classCallCheck(this, ProjectOrderService);

        this.url = webUrl.getUrl();
    }
    //Get All Project Order


    _createClass(ProjectOrderService, [{
        key: 'getAllProjectOrders',
        value: function getAllProjectOrders() {
            var url = this.url + '/admin/project_order/get_all_orders';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    console.log('Result', result);
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Add New Project Order

    }, {
        key: 'addNewOrder',
        value: function addNewOrder(inputData) {
            var url = this.url + '/admin/project_order/add_new_order';
            return new Promise(function (resolve, reject) {
                axios.post(url, inputData).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    alert(err);
                });
            });
        }
        //Update Project Details

    }, {
        key: 'updateProjectDetails',
        value: function updateProjectDetails(inputData) {
            var url = this.url + '/admin/project_order/update_order';
            return new Promise(function (resolve, reject) {
                axios.put(url, inputData).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Delete Order

    }]);

    return ProjectOrderService;
}();

/* harmony default export */ __webpack_exports__["a"] = (ProjectOrderService);

/***/ })

/******/ });