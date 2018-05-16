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

/***/ 2:
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
        // this.url=':2720';
        // this.url='http://www.ggdemo.com/public';
        this.url = 'http://ggdemo.thddns.net:2720/pogtank/public';
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

/***/ 205:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(206);


/***/ }),

/***/ 206:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_order_service__ = __webpack_require__(36);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_webUrl__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__project_order_edit__ = __webpack_require__(207);



var webUrl = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_webUrl__["a" /* default */]();
var projectOderService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_order_service__["a" /* default */]();
new Vue({
    el: '#project-order-index',
    mixins: [__WEBPACK_IMPORTED_MODULE_2__project_order_edit__["a" /* ProjectOrderEditModal */]],
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
        },

        //Open Project Order Edit Modal
        openProjectOrderEditModal: function openProjectOrderEditModal(order) {
            this.$modal.show('project-order-edit-modal', {
                // order:order
                order: order
            });
        },
        getAllProjectOrder: function getAllProjectOrder() {
            var _this2 = this;

            projectOderService.getAllProjectOrders().then(function (result) {
                if (_this2.showLoading === true) {
                    _this2.showLoading = false;
                }
                _this2.orders = result;
            }).catch(function (err) {
                alert(err);
            });
        },
        beforeCloseProjectOrderEditModal: function beforeCloseProjectOrderEditModal(data) {
            if (data.params.is_updated) {
                this.getAllProjectOrder();
            }
        },

        //Delete Project
        deleteProject: function deleteProject(order) {
            var _this3 = this;

            this.$dialog.confirm('ยืนยันการลบ').then(function () {
                _this3.showLoading = true;
                projectOderService.deleteProject(order.id).then(function (result) {
                    _this3.getAllProjectOrder();
                }).catch(function (err) {
                    alert(err);
                });
            }).catch();
        }
    }
});

/***/ }),

/***/ 207:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProjectOrderEditModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_city__ = __webpack_require__(31);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_project_order_service__ = __webpack_require__(36);


var projectOrderService = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_project_order_service__["a" /* default */]();
var cityService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_city__["a" /* default */]();
var ProjectOrderEditModal = {
    data: function data() {
        return {
            project_order_edit: {
                is_updated: false,
                showLoading: '',
                provinces: [],
                amphoes: [],
                districts: [],
                products: [],
                form: {}
            }
        };
    },

    methods: {
        beforeOpenProjectOrderEditModal: function beforeOpenProjectOrderEditModal(data) {
            this.project_order_edit.is_updated = false;
            this.project_order_edit.form = Object.assign({}, data.params.order);
        },
        openedProjectOrderEditModal: function openedProjectOrderEditModal() {
            var _this = this;

            console.log('Order Form :', this.project_order_edit.form);
            cityService.getProvinces().then(function (result) {
                _this.project_order_edit.provinces = result;
                _this.getAmphoes();
                _this.getDistricts();
            }).catch(function (err) {
                alert(err);
            });
        },
        closeProjectOrderEditModal: function closeProjectOrderEditModal() {
            this.$modal.hide('project-order-edit-modal', {
                is_updated: this.project_order_edit.is_updated
            });
        },
        projectOrderEditModal_updateDetails: function projectOrderEditModal_updateDetails(scope, event) {
            var _this2 = this;

            this.$validator.validateAll(scope).then(function (result) {
                if (result) {
                    projectOrderService.updateProjectDetails(_this2.project_order_edit.form).then(function (result) {
                        _this2.project_order_edit.is_updated = true;
                        _this2.closeProjectOrderEditModal();
                    }).catch(function (err) {});
                } else {
                    alert('กรุณาระบุข้อมูลให้ครบถ้วน');
                }
            }).catch(function (err) {
                alert(err);
            });
        },

        // -- Get Amphoe
        getAmphoes: function getAmphoes(changed) {
            console.log('Get Amphoes');
            console.log('Event Get Amphoes : ', event);
            if (changed) {
                console.log('Province Changed');
                this.project_order_edit.form.amphoe = ''; // clear old amphoe
                this.project_order_edit.form.district = ''; //clear old district
            }
            this.project_order_edit.districts.splice(0); // clear district array
            this.project_order_edit.amphoes = this.project_order_edit.form.province.amphoes;
        },

        // -- Get District
        getDistricts: function getDistricts(changed) {
            var _this3 = this;

            if (changed) {
                console.log('Amphoes Changed');
                this.project_order_edit.form.district = ''; // clear old district
            }
            cityService.getDistricts(this.project_order_edit.form.amphoe.id).then(function (result) {
                _this3.project_order_edit.districts = result;
            }).catch(function (err) {
                alert(err);
            });
        }
    }
};

/***/ }),

/***/ 31:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// import axios from 'axios';

var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var City = function () {
    function City() {
        _classCallCheck(this, City);

        this.webUrl = webUrl.getUrl();
    }
    //Static Method


    _createClass(City, [{
        key: 'getProvinces',
        value: function getProvinces() {
            var _this = this;

            return new Promise(function (resolve, reject) {
                axios.get(_this.webUrl + '/admin/materials/city/provinces').then(function (result) {
                    resolve(result.data);
                    console.log('Province :', result);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }, {
        key: 'getDistricts',
        value: function getDistricts(amphoeID) {
            console.log('Amphoe ID', amphoeID);
            var url = this.webUrl + '/admin/materials/items/districts/' + amphoeID;
            console.log('Get District URL:', url);
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }], [{
        key: 'allProvince',
        value: function allProvince() {
            var url = this.url + '/admin/materials/city/provinces';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                    console.log(result);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return City;
}();

/* harmony default export */ __webpack_exports__["a"] = (City);

/***/ }),

/***/ 36:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
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
            var url = this.url + '/admin/project_order/update_project_details';
            return new Promise(function (resolve, reject) {
                axios.put(url, inputData).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Delete Order

    }, {
        key: 'deleteProject',
        value: function deleteProject(id) {
            var url = this.url + '/admin/project_order/delete_project/' + id;
            return new Promise(function (resolve, reject) {
                axios.delete(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return ProjectOrderService;
}();

/* harmony default export */ __webpack_exports__["a"] = (ProjectOrderService);

/***/ })

/******/ });