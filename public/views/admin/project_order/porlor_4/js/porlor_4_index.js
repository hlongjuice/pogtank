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
/******/ 	return __webpack_require__(__webpack_require__.s = 224);
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

/***/ 224:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(225);


/***/ }),

/***/ 225:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_4_service__ = __webpack_require__(34);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__add_part_modal__ = __webpack_require__(226);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__assets_js_services_webUrl__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__edit_part_modal__ = __webpack_require__(227);





var webUrl = new __WEBPACK_IMPORTED_MODULE_2__assets_js_services_webUrl__["a" /* default */]();
var porlor4Service = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_4_service__["a" /* default */]();
new Vue({
    el: '#porlor-4-index',
    mixins: [__WEBPACK_IMPORTED_MODULE_1__add_part_modal__["a" /* AddNewPartModal */], __WEBPACK_IMPORTED_MODULE_3__edit_part_modal__["a" /* EditPartModal */]],
    data: {
        addNewPartStatus: false,
        order_id: orderID,
        showLoading: '',
        project_porlor_4_parts: [],
        project_details: {}
    },
    mounted: function mounted() {
        this.showLoading = true;
        this.initialData();
    },
    methods: {
        initialData: function initialData() {
            var _this = this;

            console.log('InitialData Method');
            Promise.all([
            //Project Details
            porlor4Service.getProjectDetails(this.order_id).then(function (result) {
                _this.project_details = result;
            }).catch(function (err) {}),
            //Order Parts
            porlor4Service.getAllParts(this.order_id).then(function (result) {
                console.log('Project Porlor 4 Part :', result);
                _this.project_porlor_4_parts = result;
            }).catch(function (err) {})]).then(function () {
                _this.showLoading = false;
            }).catch(function (err) {
                _this.$dialog.confirm('การโหลดข้อมูลผิดพลาด ลองใหม่อีกครั้ง').then(function () {
                    location.reload();
                }).catch(function () {});
            });
        },

        //Refresh Data
        refreshData: function refreshData() {
            var _this2 = this;

            console.log('RefreshData method');
            this.showLoading = true;
            this.addNewPartStatus = false;
            //Order Parts
            porlor4Service.getAllParts(this.order_id).then(function (result) {
                _this2.project_porlor_4_parts = result;
                _this2.showLoading = false;
            }).catch(function (err) {
                alert(err);
                _this2.showLoading = false;
            });
        },

        //Porlor 4 Delete Part
        porlor4_deletePart: function porlor4_deletePart(item) {
            var _this3 = this;

            this.$dialog.confirm('' + '<p>ยืนยันการลบ</p>' + '<h4 class="text-danger">' + item.part.name + '</h4>' + '<p>**การลบนี้จะลบงานย่อยทั้งหมดในหมวดหมู่ </p>').then(function () {
                _this3.showLoading = true;
                porlor4Service.deletePart(item.id).then(function (result) {
                    _this3.showLoading = false;
                    _this3.refreshData();
                }).catch(function (err) {
                    alert(err);
                });
            }).catch();
        },

        //Open Jobs
        openPorlor4JobsPage: function openPorlor4JobsPage(id) {
            console.log('Porlor 4 ID :', id);
            window.location = webUrl.getRoute('/admin/project_order/porlor_4_id/' + id + '/jobs');
        },

        //Open Edit Part
        openEditPartModal: function openEditPartModal(item) {
            this.$modal.show('porlor-4-edit-part-modal', {
                item: item
            });
        },
        showAddNewPartModal: function showAddNewPartModal() {
            // this.addNewPartStatus=false,
            console.log('Show Add New Part Modal');
            this.$modal.show('porlor-4-add-new-part-modal');
        },

        //Before Close Add New Part Modal
        beforeCloseAddNewPartModal: function beforeCloseAddNewPartModal() {
            if (this.addNewPartStatus) {
                console.log('Refresh');
                this.refreshData();
            }
        },
        closeAddNewPartModal: function closeAddNewPartModal() {
            this.$modal.hide('porlor-4-add-new-part-modal');
        },
        beforeCloseEditPartModal: function beforeCloseEditPartModal(data) {
            if (data.params.is_updated) {
                this.refreshData();
            }
        }
    }
});

/***/ }),

/***/ 226:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AddNewPartModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_4_part_service__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_porlor_4_service__ = __webpack_require__(34);


var porlor4Service = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_porlor_4_service__["a" /* default */]();
var porlor4PartService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_4_part_service__["a" /* default */]();
var AddNewPartModal = {
    data: function data() {
        return {
            parts: [],
            form: {
                part: ''
            }
        };
    },
    methods: {
        beforeOpenAddNewPartModal: function beforeOpenAddNewPartModal() {
            var _this = this;

            this.addNewPartStatus = false;
            this.form = {
                part: ''
            };
            this.showLoading = true;
            // porlor4PartService.getAll()
            //     .then(result=>{
            //         console.log('Get All Part :',result);
            //        this.parts=result.filter(part=>{
            //             let project_porlor_4_part= this.project_porlor_4_parts.find(item=>{
            //               return item.part_id === part.id;
            //            });
            //             // If already exist part return 0
            //             if(project_porlor_4_part){
            //                 return 0; // หมายถึงมีการใช้งาน part นี้แล้ว
            //             }else{
            //                 return 1; // หาก project porlor 4 part เป็น null คือ part นี้ยังไม่ได้ใช้งาน
            //             }
            //         });
            //         console.log('This part After filter :',this.parts);
            //         // this.parts=result;
            //         this.showLoading=false;
            //     }).catch(err=>{alert(err)});
            porlor4PartService.getAvailableParts(this.project_details.id).then(function (result) {
                _this.parts = result;
                _this.showLoading = false;
                console.log('Available Parts are :', result);
            }).catch(function (err) {
                alert(err);
                _this.showLoading = false;
            });
        },

        //Add Part
        addPart: function addPart() {
            var _this2 = this;

            porlor4Service.addNewPart(this.order_id, this.form).then(function (result) {
                _this2.addNewPartStatus = true;
                _this2.closeAddNewPartModal();
            }).catch(function (err) {
                alert(err);
            });
        }
    }
};

/***/ }),

/***/ 227:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return EditPartModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_4_part_service__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_porlor_4_service__ = __webpack_require__(34);


var porlor4Service = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_project_order_porlor_4_service__["a" /* default */]();
var porlor4PartService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_project_order_porlor_4_part_service__["a" /* default */]();
var EditPartModal = {
    data: function data() {
        return {
            edit_part: {
                is_updated: false,
                is_loading: false,
                parts: [],
                form: {
                    project_order_id: '',
                    porlor_4_id: '',
                    part: ''
                }
            }
        };
    },

    methods: {
        beforeOpenEditPartModal: function beforeOpenEditPartModal(data) {
            console.log('Item Data :', data.params.item);
            var item = data.params.item;
            this.edit_part.is_updated = false;
            this.edit_part.form.project_order_id = item.project_order_id;
            this.edit_part.form.porlor_4_id = item.id;
            this.edit_part.form.part = item.part;
        },
        openedEditPartModal: function openedEditPartModal() {
            var _this = this;

            console.log('Edit Part Form', this.edit_part.form);
            this.edit_part.is_loading = true;
            porlor4PartService.getAvailableParts(this.edit_part.form.project_order_id, this.edit_part.form.porlor_4_id).then(function (result) {
                console.log('Get Available Part : ', result);
                _this.edit_part.is_loading = false;
                _this.edit_part.parts = result;
            }).catch(function (err) {
                alert(err);
            });
        },
        closeEditPartModal: function closeEditPartModal() {
            this.$modal.hide('porlor-4-edit-part-modal', {
                is_updated: this.edit_part.is_updated
            });
        },
        porlor4EditModal_updatePart: function porlor4EditModal_updatePart(scope, event) {
            var _this2 = this;

            this.$validator.validateAll(scope).then(function (result) {
                if (result) {
                    _this2.edit_part.is_loading = true;
                    porlor4Service.updatePart(_this2.edit_part.form).then(function (result) {
                        _this2.edit_part.is_updated = true;
                        _this2.closeEditPartModal();
                        _this2.edit_part.is_loading = false;
                    }).catch(function (err) {
                        alert(err);
                    });
                } else {
                    alert('กรุณาระบุข้อมูล');
                }
            });
        }
    }
};

/***/ }),

/***/ 34:
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
    //Add New Part


    _createClass(Porlor4Service, [{
        key: 'addNewPart',
        value: function addNewPart(order_id, dataInput) {
            var url = this.url + '/admin/project_order/' + order_id + '/porlor_4/add_part';
            return new Promise(function (resolve, reject) {
                axios.post(url, dataInput).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Delete Part

    }, {
        key: 'deletePart',
        value: function deletePart(porlor_4_id) {
            var _this = this;

            var url = this.url + '/admin/project_order/porlor_4/delete_part/' + porlor_4_id;
            return new Promise(function (resolve, reject) {
                axios.post(url, _this._delete_method).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get All Porlor 4

    }, {
        key: 'getAllParts',
        value: function getAllParts(order_id) {
            var url = this.url + '/admin/project_order/' + order_id + '/porlor_4/get_all_parts';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get Project Details

    }, {
        key: 'getProjectDetails',
        value: function getProjectDetails(order_id) {
            var url = this.url + '/admin/project_order/' + order_id + '/porlor_4/get_project_details';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    console.log('Get Project Details Service');
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Update Part

    }, {
        key: 'updatePart',
        value: function updatePart(dataInputs) {
            dataInputs._method = 'PUT';
            var url = this.url + '/admin/project_order/porlor_4/update_part';
            return new Promise(function (resolve, reject) {
                axios.post(url, dataInputs).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return Porlor4Service;
}();

/* harmony default export */ __webpack_exports__["a"] = (Porlor4Service);

/***/ }),

/***/ 35:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(2);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var Porlor4Part = function () {
    function Porlor4Part() {
        _classCallCheck(this, Porlor4Part);

        this.url = webUrl.getUrl();
        this._delete_method = {
            _method: 'DELETE'
        };
        this._put_method = {
            _method: 'PUT'
        };
    }
    //Add New Part


    _createClass(Porlor4Part, [{
        key: 'addNewPart',
        value: function addNewPart(dataInputs) {
            var url = this.url + '/admin/porlor_4_parts/add_new_part';
            return new Promise(function (resolve, reject) {
                axios.post(url, dataInputs).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get All Parts

    }, {
        key: 'getAll',
        value: function getAll() {
            var url = this.url + '/admin/porlor_4_parts/get_all';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                    console.log('Porlor 4 Part Service :', result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get Available Parts

    }, {
        key: 'getAvailableParts',
        value: function getAvailableParts(project_order_id) {
            var porlor_4_id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

            var url = this.url + '/admin/porlor_4_parts/get_available_parts/' + project_order_id + '/porlor_4/' + porlor_4_id;
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return Porlor4Part;
}();

/* harmony default export */ __webpack_exports__["a"] = (Porlor4Part);

/***/ })

/******/ });