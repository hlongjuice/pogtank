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
/******/ 	return __webpack_require__(__webpack_require__.s = 56);
/******/ })
/************************************************************************/
/******/ ({

/***/ 56:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(57);


/***/ }),

/***/ 57:
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//Custom Error Message
var dict = {
    custom: {
        typeName: { required: 'ชื่อหมวดหมู่' },
        parentTypeID: { required: 'ลำดับหมวดหมู่' },
        codePrefix: { required: 'รหัสหมวดหมู่' }
    }
};
var vm = new Vue(_defineProperty({
    el: '#app',
    //Created
    created: function created() {
        this.$validator.localize('en', dict);
    },
    //Data
    data: {
        parentTypes: parentTypeModel,
        form: {
            typeName: '',
            parentType: {
                id: 0,
                name: 'หมวดหมู่หลัก'
            },
            details: '',
            codePrefix: '',
            parentTypeID: 0
        }
    },
    //End Data
    //Method
    methods: {
        validateForm: function validateForm(scope, ev) {
            this.$validator.validateAll(scope).then(function (result) {
                if (result) {
                    axios.post('/admin/materials/types', vm.form).then(function (result) {
                        window.location = indexRoute;
                    }).catch(function (err) {
                        alert("ไม่สามารถเพิ่มข้อมูลได้ลองใหม่อีกครั้ง");
                        console.log(err);
                    });
                } else {
                    alert('Error');
                }
            });
        }
    },
    watch: {
        'form.parentType': function formParentType() {
            this.form.parentTypeID = this.form.parentType.id;
        }
    }
}, 'created', function created() {}));

/***/ })

/******/ });