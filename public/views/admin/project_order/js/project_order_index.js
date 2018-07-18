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
/******/ 	return __webpack_require__(__webpack_require__.s = 241);
/******/ })
/************************************************************************/
/******/ ({

/***/ 170:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var RefereeRankService = function () {
    function RefereeRankService() {
        _classCallCheck(this, RefereeRankService);

        this.url = webUrl.getUrl();
        this._delete_method = {
            _method: 'DELETE'
        };
    }
    //Add New Referee


    _createClass(RefereeRankService, [{
        key: 'addRefereeRanks',
        value: function addRefereeRanks(dataInput) {
            var url = this.url + '/admin/referee_rank/add_referee_rank';
            return new Promise(function (resolve, reject) {
                axios.post(url, dataInput).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get All Referee

    }, {
        key: 'getRefereeRanks',
        value: function getRefereeRanks() {
            var url = this.url + '/admin/referee_rank/get_referee_ranks';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Update Referee

    }, {
        key: 'updateRank',
        value: function updateRank(referee_id, dataInput) {
            dataInput._method = 'PUT';
            var url = this.url + '/admin/referee_rank/update_referee_rank/' + referee_id;
            return new Promise(function (resolve, reject) {
                axios.post(url, dataInput).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return RefereeRankService;
}();

/* harmony default export */ __webpack_exports__["a"] = (RefereeRankService);

/***/ }),

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
        // this.url='http://ggdemo.thddns.net:2720/pogtank/public'
        this.url = '';
        // this.url='/public';
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

/***/ 241:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(242);


/***/ }),

/***/ 242:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_order_service__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_porlor_4_export_service__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__assets_js_services_project_order_porlor_5_porlor_5_export_service__ = __webpack_require__(243);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__assets_js_services_project_order_porlor_6_porlor_6_export_service__ = __webpack_require__(244);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__assets_js_services_webUrl__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__project_order_edit__ = __webpack_require__(245);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__porlor_5_porlor_5_index__ = __webpack_require__(246);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__porlor_6_porlor_6_index__ = __webpack_require__(248);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__referee_referee_index__ = __webpack_require__(250);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__referee_add_referee_add_referee__ = __webpack_require__(251);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__referee_edit_referee_edit_referee__ = __webpack_require__(252);












var webUrl = new __WEBPACK_IMPORTED_MODULE_4__assets_js_services_webUrl__["a" /* default */]();
var projectOderService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_order_service__["a" /* default */]();
var porlor4ExportService = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_porlor_4_export_service__["a" /* default */]();
var porlor5ExportService = new __WEBPACK_IMPORTED_MODULE_2__assets_js_services_project_order_porlor_5_porlor_5_export_service__["a" /* default */]();
var porlor6ExportService = new __WEBPACK_IMPORTED_MODULE_3__assets_js_services_project_order_porlor_6_porlor_6_export_service__["a" /* default */]();
new Vue({
    el: '#project-order-index',
    mixins: [__WEBPACK_IMPORTED_MODULE_5__project_order_edit__["a" /* ProjectOrderEditModal */], __WEBPACK_IMPORTED_MODULE_6__porlor_5_porlor_5_index__["a" /* Porlor5Index */], __WEBPACK_IMPORTED_MODULE_7__porlor_6_porlor_6_index__["a" /* Porlor6Index */], __WEBPACK_IMPORTED_MODULE_8__referee_referee_index__["a" /* ProjectReferee */], __WEBPACK_IMPORTED_MODULE_9__referee_add_referee_add_referee__["a" /* ProjectRefereeAddModal */], __WEBPACK_IMPORTED_MODULE_10__referee_edit_referee_edit_referee__["a" /* ProjectRefereeEditModal */]],
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
                order: order
            });
        },

        //Open Porlor 5
        openPorlor5Modal: function openPorlor5Modal(order) {
            this.$modal.show('porlor-5-modal', {
                order: order
            });
        },
        //Open Porlor 6
        openPorlor6Modal: function openPorlor6Modal(order) {
            this.$modal.show('porlor-6-modal', {
                order: order
            });
        },

        //Open Project Referee
        openProjectReferee: function openProjectReferee(order) {
            this.$modal.show('project-referee-modal', {
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

        //Before Close Porlor 5
        beforeClosePorlor5Modal: function beforeClosePorlor5Modal() {},
        //Before Close Porlor 6
        beforeClosePorlor6Modal: function beforeClosePorlor6Modal() {},

        //Before Close Project Referee Modal
        beforeCloseProjectRefereeModal: function beforeCloseProjectRefereeModal() {},

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
        },

        //Export Porlor 4
        exportPorlor4Excel: function exportPorlor4Excel(order_id) {
            porlor4ExportService.exportExcelByProjectOrderID(order_id);
        },

        //Export Porlor 5
        exportPorlor5Excel: function exportPorlor5Excel(order_id) {
            porlor5ExportService.exportExcel(order_id);
        },

        //Export Porlor 6
        exportPorlor6Excel: function exportPorlor6Excel(order_id) {
            porlor6ExportService.exportExcel(order_id);
        }
    }
});

/***/ }),

/***/ 243:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var Porlor5ExportService = function () {
    function Porlor5ExportService() {
        _classCallCheck(this, Porlor5ExportService);

        this.url = webUrl.getUrl();
        this._put_method = {
            _method: 'PUT'
        };
    }

    _createClass(Porlor5ExportService, [{
        key: 'exportExcel',
        value: function exportExcel(project_order_id) {
            var url = this.url + '/project/export/porlor5/excel/' + project_order_id;
            window.open(url);
        }
    }]);

    return Porlor5ExportService;
}();

/* harmony default export */ __webpack_exports__["a"] = (Porlor5ExportService);

/***/ }),

/***/ 244:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var Porlor6ExportService = function () {
    function Porlor6ExportService() {
        _classCallCheck(this, Porlor6ExportService);

        this.url = webUrl.getUrl();
        this._put_method = {
            _method: 'PUT'
        };
    }
    //Get Porlor6


    _createClass(Porlor6ExportService, [{
        key: 'exportExcel',
        value: function exportExcel(project_order_id) {
            var url = this.url + '/project/export/porlor6/excel/' + project_order_id;
            window.open(url);
        }
    }]);

    return Porlor6ExportService;
}();

/* harmony default export */ __webpack_exports__["a"] = (Porlor6ExportService);

/***/ }),

/***/ 245:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProjectOrderEditModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_city__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_project_order_service__ = __webpack_require__(39);


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

            console.log('Update Form :', this.project_order_edit.form);
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

/***/ 246:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Porlor5Index; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_5_porlor_5_service__ = __webpack_require__(247);


var porlor5Service = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_5_porlor_5_service__["a" /* default */]();
var Porlor5Index = {
    data: function data() {
        return {
            porlor5: {
                is_loading: false,
                parts: '',
                project: '',
                project_order: ''
            }

        };
    },

    methods: {
        beforeOpenPorlor5Modal: function beforeOpenPorlor5Modal(data) {
            this.porlor5.project_order = data.params.order;
        },
        openedPorlor5Modal: function openedPorlor5Modal() {
            var _this = this;

            this.porlor5.is_loading = true;
            Promise.all([this.porlor5_getPorlor5()]).then(function () {
                _this.porlor5.is_loading = false;
            }).catch(function (err) {
                alert(err);
            });
        },
        closePorlor5Modal: function closePorlor5Modal() {
            this.$modal.hide('porlor-5-modal');
        },

        //porlor5
        //-- Get Porlor Items
        porlor5_getPorlor5: function porlor5_getPorlor5() {
            var _this2 = this;

            porlor5Service.getPorlor5(this.porlor5.project_order.id).then(function (result) {
                console.log(result);
                _this2.porlor5.project = result;
                _this2.porlor5.is_loading = false;
            }).catch(function (err) {
                alert(err);
                _this2.porlor5.is_loading = false;
            });
        },

        //-- move to Previous Page
        porlor5_moveToPreviousPage: function porlor5_moveToPreviousPage(porlor4) {
            var _this3 = this;

            this.porlor5.is_loading = true;
            porlor5Service.moveToPreviousPage(porlor4.project_order_id, porlor4.id).then(function (result) {
                _this3.porlor5_getPorlor5();
            }).catch(function (err) {
                alert(err);
                _this3.porlor5.is_loading = false;
            });
        },

        //-- Move to next Page
        porlor5_moveToNextPage: function porlor5_moveToNextPage(porlor4) {
            var _this4 = this;

            this.porlor5.is_loading = true;
            porlor5Service.moveToNextPage(porlor4.project_order_id, porlor4.id).then(function (result) {
                _this4.porlor5_getPorlor5();
            }).catch(function (err) {
                alert(err);
                _this4.porlor5.is_loading = false;
            });
        }
    }
};

/***/ }),

/***/ 247:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var Porlor5Service = function () {
    function Porlor5Service() {
        _classCallCheck(this, Porlor5Service);

        this.url = webUrl.getUrl();
        this._put_method = {
            _method: 'PUT'
        };
    }
    //Get Porlor5


    _createClass(Porlor5Service, [{
        key: 'getPorlor5',
        value: function getPorlor5(project_order_id) {
            var url = this.url + '/admin/project_order/' + project_order_id + '/porlor_5';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Move to Previous Page

    }, {
        key: 'moveToPreviousPage',
        value: function moveToPreviousPage(project_order_id, porlor4_id) {
            var _this = this;

            var url = this.url + '/admin/project_order/' + project_order_id + '/porlor_5/porlor4/move_to_previous_page/' + porlor4_id;
            return new Promise(function (resolve, reject) {
                axios.post(url, _this._put_method).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Move to Next Page

    }, {
        key: 'moveToNextPage',
        value: function moveToNextPage(project_order_id, porlor4_id) {
            var _this2 = this;

            var url = this.url + '/admin/project_order/' + project_order_id + '/porlor_5/porlor4/move_to_next_page/' + porlor4_id;
            return new Promise(function (resolve, reject) {
                axios.post(url, _this2._put_method).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return Porlor5Service;
}();

/* harmony default export */ __webpack_exports__["a"] = (Porlor5Service);

/***/ }),

/***/ 248:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Porlor6Index; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_6_porlor_6_service__ = __webpack_require__(249);


var porlor6Service = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_6_porlor_6_service__["a" /* default */]();
var Porlor6Index = {
    data: function data() {
        return {
            porlor6: {
                is_loading: false,
                project: '',
                project_order: '',
                blank_rows: []
            }

        };
    },

    methods: {
        beforeOpenPorlor6Modal: function beforeOpenPorlor6Modal(data) {
            this.porlor6.project_order = data.params.order;
        },
        openedPorlor6Modal: function openedPorlor6Modal() {
            var _this = this;

            for (var i = 0; i < 5; i++) {
                this.porlor6.blank_rows.push('');
            }
            this.porlor6.is_loading = true;
            Promise.all([this.porlor6_getPorlor6()]).then(function () {
                _this.porlor6.is_loading = false;
            }).catch(function (err) {
                alert(err);
            });
        },
        closePorlor6Modal: function closePorlor6Modal() {
            this.$modal.hide('porlor-6-modal');
        },

        //porlor6
        //-- Get Porlor Items
        porlor6_getPorlor6: function porlor6_getPorlor6() {
            var _this2 = this;

            porlor6Service.getPorlor6(this.porlor6.project_order.id).then(function (result) {
                console.log('Porlor 6 : ', result);
                _this2.porlor6.project = result;
                _this2.porlor6.is_loading = false;
            }).catch(function (err) {
                alert(err);
                _this2.porlor6.is_loading = false;
            });
        }
    }
};

/***/ }),

/***/ 249:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var Porlor6Service = function () {
    function Porlor6Service() {
        _classCallCheck(this, Porlor6Service);

        this.url = webUrl.getUrl();
        this._put_method = {
            _method: 'PUT'
        };
    }
    //Get Porlor5


    _createClass(Porlor6Service, [{
        key: 'getPorlor6',
        value: function getPorlor6(project_order_id) {
            var url = this.url + '/admin/project_order/' + project_order_id + '/porlor_6';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return Porlor6Service;
}();

/* harmony default export */ __webpack_exports__["a"] = (Porlor6Service);

/***/ }),

/***/ 250:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProjectReferee; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_referee_service__ = __webpack_require__(42);

var projectRefereeService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_project_referee_service__["a" /* default */]();
var ProjectReferee = {
    data: function data() {
        return {
            project_referee: {
                is_loading: false,
                is_scrollable: true,
                project_order: '',
                referees: [],
                select_all_referees: false,
                form: {
                    selected_referees: []
                }
            }
        };
    },

    methods: {
        beforeOpenProjectRefereeModal: function beforeOpenProjectRefereeModal(data) {
            this.projectReferee_resetData();
            this.project_referee.project_order = data.params.order;
        },
        openedProjectRefereeModal: function openedProjectRefereeModal() {
            var _this = this;

            this.project_referee.is_loading = true;
            Promise.all([this.projectReferee_getReferees()]).then(function () {
                setTimeout(function () {
                    _this.project_referee.is_loading = false;
                }, 300);
            }).catch(function (err) {
                alert(err);
                _this.project_referee.is_loading = false;
            });
        },
        beforeCloseProjectRefereeAddModal: function beforeCloseProjectRefereeAddModal(data) {
            console.log('Before Close Project Referee Add Modal Data :', data);
            this.project_referee.is_scrollable = true;
            if (data.params.is_added) {
                this.projectReferee_getReferees();
            }
        },
        beforeCloseProjectRefereeEditModal: function beforeCloseProjectRefereeEditModal(data) {
            this.project_referee.is_scrollable = true;
            if (data.params.is_updated) {
                this.projectReferee_getReferees();
            }
        },
        closeProjectRefereeModal: function closeProjectRefereeModal() {
            this.$modal.hide('project-referee-modal');
        },
        openProjectRefereeAddModal: function openProjectRefereeAddModal() {
            this.project_referee.is_scrollable = false;
            this.$modal.show('project-referee-add-modal', {
                order: this.project_referee.project_order
            });
        },
        openProjectRefereeEditModal: function openProjectRefereeEditModal(referee) {
            this.project_referee.is_scrollable = false;
            this.$modal.show('project-referee-edit-modal', {
                order: this.project_referee.project_order,
                referee: referee
            }, { draggable: true });
        },

        //Project Referee Methods
        //-- Add New Referee
        //-- Get Porlor Items
        projectReferee_getReferees: function projectReferee_getReferees() {
            var _this2 = this;

            console.log('Get Referees');
            this.project_referee.is_loading = true;
            projectRefereeService.getReferees(this.project_referee.project_order.id).then(function (result) {
                console.log(result);
                _this2.project_referee.referees = result;
                _this2.project_referee.is_loading = false;
            }).catch(function (err) {
                alert(err);
                _this2.project_referee.is_loading = false;
            });
        },

        //-- Delete Referee
        projectReferee_deleteReferee: function projectReferee_deleteReferee(referee) {
            this.project_referee.form.selected_referees.splice(0);
            this.project_referee.select_all_referees = false;
            this.project_referee.form.selected_referees.push(referee);
            this.projectReferee_deleteMultipleReferees();
        },

        //-- Delete Multiple Referees
        projectReferee_deleteMultipleReferees: function projectReferee_deleteMultipleReferees() {
            var _this3 = this;

            var referee_names = this.project_referee.form.selected_referees.map(function (referee) {
                return referee.name;
            }).join("<br />");
            this.$dialog.confirm('ยืนยันการลบรายการ <br>' + '' + referee_names).then(function () {
                projectRefereeService.deleteReferees(_this3.project_referee.project_order.id, _this3.project_referee.form).then(function (result) {
                    _this3.projectReferee_resetData();
                    _this3.projectReferee_getReferees();
                }).catch(function (err) {
                    alert(err);
                });
            }).catch();
        },
        projectReferee_resetData: function projectReferee_resetData() {
            console.log('Reset Referee Data');
            this.project_referee.is_loading = false;
            this.project_referee.is_scrollable = true;
            this.project_referee.select_all_referees = false;
            this.project_referee.referees = [];
        },
        projectReferee_selectAllReferees: function projectReferee_selectAllReferees() {
            var _this4 = this;

            this.project_referee.form.selected_referees.splice(0);
            if (this.project_referee.select_all_referees) {
                this.project_referee.referees.forEach(function (referee) {
                    _this4.project_referee.form.selected_referees.push(referee);
                });
            }
        }
    }
};

/***/ }),

/***/ 251:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProjectRefereeAddModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_referee_referee_rank_service__ = __webpack_require__(170);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_project_referee_service__ = __webpack_require__(42);


var projectRefereeService = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_project_referee_service__["a" /* default */]();
var refereeRankService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_referee_referee_rank_service__["a" /* default */]();
var ProjectRefereeAddModal = {
    data: function data() {
        return {
            project_referee_add: {
                is_loading: false,
                is_added: false,
                ranks: '',
                project_order: '',
                form: {
                    new_referees: []
                }
            }
        };
    },

    methods: {
        beforeOpenProjectRefereeAddModal: function beforeOpenProjectRefereeAddModal(data) {
            this.projectRefereeAdd_resetData();
            this.project_referee_add.project_order = data.params.order;
            console.log('Before Open Project Referee Add Data :', this.project_referee_add);
        },
        openedProjectRefereeAddModal: function openedProjectRefereeAddModal() {
            var _this = this;

            this.project_referee_add.is_loading = true;
            //Clear Data
            Promise.all([
            //Get Referee Ranks
            this.projectRefereeAdd_getRefereeRanks()]).then(function () {
                _this.project_referee_add.is_loading = false;
            }).catch(function () {
                _this.project_referee_add.is_loading = false;
            });
        },
        closeProjectRefereeAddModal: function closeProjectRefereeAddModal() {
            this.$modal.hide('project-referee-add-modal', {
                is_added: this.project_referee_add.is_added
            });
        },

        //Project Referee Add Modal
        //Reset Data
        projectRefereeAdd_resetData: function projectRefereeAdd_resetData() {
            this.project_referee_add = {
                is_loading: false,
                is_added: false,
                ranks: [],
                project_order: '',
                form: {
                    new_referees: [{
                        project_order_id: '',
                        name: '',
                        rank: ''
                    }]
                }
            };
        },

        //Add New Referees to Database
        projectRefereeAdd_addReferees: function projectRefereeAdd_addReferees(scope, event) {
            var _this2 = this;

            this.project_referee_add.is_loading = true;
            this.$validator.validateAll(scope).then(function (result) {
                if (result) {
                    projectRefereeService.addReferees(_this2.project_referee_add.project_order.id, _this2.project_referee_add.form).then(function (result) {
                        _this2.project_referee_add.is_added = true;
                        _this2.closeProjectRefereeAddModal();
                    }).catch(function (err) {
                        alert(err);
                    });
                }
            });
        },

        //Add Referee Input
        projectRefereeAdd_addRefereeInput: function projectRefereeAdd_addRefereeInput() {
            var new_referee_input = {
                project_order_id: '',
                prefix: '',
                name: '',
                rank: ''
            };
            this.project_referee_add.form.new_referees.push(new_referee_input);
        },

        //Get Referee Ranks
        projectRefereeAdd_getRefereeRanks: function projectRefereeAdd_getRefereeRanks() {
            var _this3 = this;

            refereeRankService.getRefereeRanks().then(function (result) {
                _this3.project_referee_add.ranks = result;
                console.log('Referee Ranks are :', result);
            }).catch(function (err) {
                alert(err);
            });
        },

        //Remove Referee Input
        projectRefereeAdd_removeRefereeInput: function projectRefereeAdd_removeRefereeInput(index) {
            this.project_referee_add.form.new_referees.splice(index, 1);
        }
    }
};

/***/ }),

/***/ 252:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProjectRefereeEditModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_referee_referee_rank_service__ = __webpack_require__(170);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_project_referee_service__ = __webpack_require__(42);



var projectRefereeService = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_project_referee_service__["a" /* default */]();
var refereeRankService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_referee_referee_rank_service__["a" /* default */]();
var ProjectRefereeEditModal = {
    data: function data() {
        return {
            project_referee_edit: {
                is_loading: false,
                is_updated: false,
                ranks: '',
                project_order: '',
                form: {
                    referee: ''
                }
            }
        };
    },

    methods: {
        beforeOpenProjectRefereeEditModal: function beforeOpenProjectRefereeEditModal(data) {
            console.log('Edit Modal Params:', data);
            this.projectRefereeEdit_resetData();
            this.project_referee_edit.project_order = data.params.order;
            this.project_referee_edit.form.referee = data.params.referee;
            console.log('Before Open Project Referee Edit Data :', this.project_referee_edit);
        },
        openedProjectRefereeEditModal: function openedProjectRefereeEditModal() {
            var _this = this;

            this.project_referee_edit.is_loading = true;
            //Clear Data
            Promise.all([
            //Get Referee Ranks
            this.projectRefereeEdit_getRefereeRanks()]).then(function () {
                _this.project_referee_edit.is_loading = false;
            }).catch(function () {
                _this.project_referee_edit.is_loading = false;
            });
        },
        closeProjectRefereeEditModal: function closeProjectRefereeEditModal() {
            this.$modal.hide('project-referee-edit-modal', {
                is_updated: this.project_referee_edit.is_updated
            });
        },

        //Project Referee Add Modal
        //Get Referee Ranks
        projectRefereeEdit_getRefereeRanks: function projectRefereeEdit_getRefereeRanks() {
            var _this2 = this;

            refereeRankService.getRefereeRanks().then(function (result) {
                _this2.project_referee_edit.ranks = result;
                console.log('Referee Ranks are :', result);
            }).catch(function (err) {
                alert(err);
            });
        },

        //Reset Data
        projectRefereeEdit_resetData: function projectRefereeEdit_resetData() {
            this.project_referee_edit.is_loading = false;
            this.project_referee_edit.is_updated = false;
            this.project_referee_edit.form.referee = '';
        },

        //Update Referee
        projectRefereeEdit_updateReferee: function projectRefereeEdit_updateReferee(scope, event) {
            var _this3 = this;

            this.$validator.validateAll(scope).then(function (result) {
                if (result) {
                    _this3.project_referee_edit.is_loading = true;
                    projectRefereeService.updateReferee(_this3.project_referee_edit.project_order.id, _this3.project_referee_edit.form).then(function (result) {
                        _this3.project_referee_edit.is_updated = true;
                        _this3.closeProjectRefereeEditModal();
                    }).catch(function (err) {
                        alert(err);
                        _this3.project_referee_edit.is_loading = false;
                    });
                }
            });
        }
    }
};

/***/ }),

/***/ 33:
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

/***/ 35:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var Porlor4Service = function () {
    function Porlor4Service() {
        _classCallCheck(this, Porlor4Service);

        this.url = webUrl.getUrl();
        this._delete_method = {
            _method: 'DELETE'
        };
    }

    //Excel
    // -- Export Single Job


    _createClass(Porlor4Service, [{
        key: 'exportExcelByRootID',
        value: function exportExcelByRootID(porlor4_id, root_job_id) {
            var url = this.url + '/project/export/porlor4/excel/by_root_job_id/' + porlor4_id + '/job/' + root_job_id;
            window.open(url); //Open New Tab
        }
        // -- Export By Part ID

    }, {
        key: 'exportExcelByPartID',
        value: function exportExcelByPartID(porlor4_id) {
            var url = this.url + '/project/export/porlor4/excel/by_part_id/' + porlor4_id;
            window.open(url); //Open New Tab
        }
        // -- Export By Project Order ID

    }, {
        key: 'exportExcelByProjectOrderID',
        value: function exportExcelByProjectOrderID(project_order_id) {
            var url = this.url + '/project/export/porlor4/excel/by_project_id/' + project_order_id;
            window.open(url); //Open New Tab
        }
    }]);

    return Porlor4Service;
}();

/* harmony default export */ __webpack_exports__["a"] = (Porlor4Service);

/***/ }),

/***/ 39:
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
        this._delete_method = {
            _method: 'DELETE'
        };
        this._put_method = {
            _method: 'PUT'
        };
    }
    //Add New Project Order


    _createClass(ProjectOrderService, [{
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
        //Get Project Details

    }, {
        key: 'getProjectDetails',
        value: function getProjectDetails(project_order_id) {
            var url = this.url + '/admin/project_order/get_project_details/' + project_order_id;
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    console.log('Result', result);
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get All Project Order

    }, {
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
        //Update Project Details

    }, {
        key: 'updateProjectDetails',
        value: function updateProjectDetails(inputData) {
            var url = this.url + '/admin/project_order/update_project_details';
            inputData._method = 'PUT';
            return new Promise(function (resolve, reject) {
                axios.post(url, inputData).then(function (result) {
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
            var _this = this;

            var url = this.url + '/admin/project_order/delete_project/' + id;
            return new Promise(function (resolve, reject) {
                axios.post(url, _this._delete_method).then(function (result) {
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

/***/ }),

/***/ 42:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var ProjectRefereeService = function () {
    function ProjectRefereeService() {
        _classCallCheck(this, ProjectRefereeService);

        this.url = webUrl.getUrl();
        this._delete_method = {
            _method: 'DELETE'
        };
        this._put_method = {
            _method: 'PUT'
        };
    }
    //Add New Referee


    _createClass(ProjectRefereeService, [{
        key: 'addReferees',
        value: function addReferees(project_order_id, inputData) {
            var url = this.url + '/admin/project_order/referee/add_referees/' + project_order_id;
            return new Promise(function (resolve, reject) {
                axios.post(url, inputData).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Delete Project Referee

    }, {
        key: 'deleteReferees',
        value: function deleteReferees(project_order_id, inputData) {
            //Add _method สำหรับ Delete Method ที่ Api
            inputData._method = 'DELETE';
            var url = this.url + '/admin/project_order/referee/delete_referees/' + project_order_id;
            return new Promise(function (resolve, reject) {
                axios.post(url, inputData).then(function (result) {
                    console.log('Result', result);
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get Referees

    }, {
        key: 'getReferees',
        value: function getReferees(project_order_id) {
            var url = this.url + '/admin/project_order/referee/get_referees/' + project_order_id;
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Update Referee

    }, {
        key: 'updateReferee',
        value: function updateReferee(project_order_id, inputData) {
            inputData._method = 'PUT';
            var url = this.url + '/admin/project_order/referee/update_referee/' + project_order_id;
            return new Promise(function (resolve, reject) {
                axios.post(url, inputData).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return ProjectRefereeService;
}();

/* harmony default export */ __webpack_exports__["a"] = (ProjectRefereeService);

/***/ })

/******/ });