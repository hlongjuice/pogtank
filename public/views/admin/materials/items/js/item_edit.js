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
/******/ 	return __webpack_require__(__webpack_require__.s = 52);
/******/ })
/************************************************************************/
/******/ ({

/***/ 52:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(53);


/***/ }),

/***/ 53:
/***/ (function(module, exports) {

var dict = {
    custom: {
        materialName: { required: 'ชื่อสินค้า' },
        materialTypeID: { required: 'ประเภท' },
        materialUnit: { required: 'หน่วย' }
    }
};
var vm = new Vue({
    el: '#app',
    data: {
        materialName: '',
        test: 'abc',
        item: '',
        materialTypes: materialTypes,
        provinces: provinces,
        form: {
            cities: [],
            materialVendor: '',
            materialName: globalPrice.name,
            materialUnit: globalPrice.unit,
            materialType: globalPrice.type,
            materialTypeID: globalPrice.type.id,
            globalCost: globalPrice.global_cost,
            globalPrice: globalPrice.global_price,
            invoiceCost: globalPrice.invoice_cost,
            invoicePrice: globalPrice.invoice_price
        },
        displayStatus: []
    },
    created: function created() {
        var _this = this;

        this.$validator.localize('en', dict);
        this.displayStatus.push(false);
        material.local_prices.forEach(function (item) {
            _this.form.cities.push({
                province: item.province,
                amphoe: item.amphoe,
                district: item.district,
                amphoes: item.province ? item.province.amphoes : [],
                districts: item.amphoe ? item.amphoe.districts : [],
                localCost: item.cost,
                localPrice: item.price,
                wage: item.wage
            });
        });
    },
    //Methods
    methods: {
        //Modal
        showAddPriceModal: function showAddPriceModal() {
            this.$modal.show('add-local-price-modal', {
                form: this.form
            });
        },
        // -- Form Validation
        validateForm: function validateForm(scope, ev) {
            this.$validator.validateAll(scope).then(function (result) {
                var errMassage = 'กรุณาระบุ ';
                if (result) {
                    axios.post('/admin/materials/items', vm.form).then(function (result) {
                        window.location = indexRoute + '/updated';
                    });
                    return;
                }

                vm.$validator.errors.items.forEach(function (error) {
                    errMassage = errMassage + error.msg + ', ';
                });
                alert(errMassage);
                ev.preventDefault();
            });
        },
        // -- Add more Local Price Input
        addPriceInput: function addPriceInput() {
            var city = {
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: []
            };
            this.form.cities.push(city);
        },
        // -- Get Amphoe
        getAmphoes: function getAmphoes(index) {
            this.form.cities[index].amphoe = ''; // clear old amphoe
            this.form.cities[index].district = ''; //clear old district
            this.form.cities[index].districts.splice(0);
            this.form.cities[index].amphoes = this.form.cities[index].province.amphoes;
        },
        // -- Get District
        getDistricts: function getDistricts(index) {
            this.form.cities[index].district = ''; // clear old district
            axios.get('/admin/materials/items/districts/' + this.form.cities[index].amphoe.id).then(function (result) {
                vm.form.cities[index].districts = result.data;
                console.log(result.data);
            }).catch(function (err) {
                console.log(err);
            });
        },
        // -- Delete Local Price Input
        deleteLocalPrice: function deleteLocalPrice(number) {
            console.log(number);
        }
    },
    watch: {
        'form.materialType': function formMaterialType() {
            this.form.materialTypeID = this.form.materialType.id;
        }
    }
});

console.log(vm.form);

/***/ })

/******/ });