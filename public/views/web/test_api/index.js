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
/******/ 	return __webpack_require__(__webpack_require__.s = 400);
/******/ })
/************************************************************************/
/******/ ({

/***/ 400:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(401);


/***/ }),

/***/ 401:
/***/ (function(module, exports) {


// import axios from 'axios';


// var config = {
//     headers: {'X-CSRF-TOKEN':token}
// };
var token = $('meta[name="csrf-token"]').attr('content');
console.log('Token', token);
new Vue({
    el: '#test-api-index',
    data: {
        token: token,
        itemsThaiData: [],
        urlThaiData: 'http://www.ggdemo.com/public/test_api/get_item',
        urlThaiDelete: 'http://www.ggdemo.com/public/test_api/delete/10',
        urlThaiDataPut: 'http://www.ggdemo.com/public/test_api/update_item/50',
        urlHomePut: 'http://ggdemo.thddns.net:2720/pogtank/public/test_api/update_item/50',
        urlHome: 'http://ggdemo.thddns.net:2720/pogtank/public/test_api/get_item',
        urlSample: 'http://www.ggeverything.com',
        urlPostSample: 'http://www.ggeverything.com/post_api.php',
        urlLocalPut: 'http://localhost/pogtank/public/test_api/update_item/50',
        itemsHome: []

    },
    mounted: function mounted() {

        // axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        this.getItems();
    },

    methods: {
        getItems: function getItems() {
            var _this = this;

            // axios.get('http://www.ggdemo.com/test_api/get_item')
            //Home Server
            axios.get(this.urlHome).then(function (result) {
                _this.itemsHome = result.data;
            }).catch(function (err) {
                console.log('Error Api From Home Server');
            });
            //
            // //Thai data
            // axios.get(this.urlThaiData)
            //     .then(result=>{
            //         this.itemsThaiData=result.data
            //     }).catch(err=>{
            //     console.log('Error Api From Thaidatahosting Server')
            //     });

            var input = {
                name: 'Yo!!'
            };

            axios.get(this.urlSample).then(function (result) {
                console.log('GGEverything Put');
                console.log(result);
            }).catch(function (err) {
                console.log(err);
            });
            // $.post(this.urlPostSample,input,function(data){
            //     console.log('Normal Get');
            //     console.log(data)
            // })
        }
    }
});

/***/ })

/******/ });