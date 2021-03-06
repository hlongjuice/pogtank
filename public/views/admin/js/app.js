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
/******/ 	return __webpack_require__(__webpack_require__.s = 65);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(3);
var isBuffer = __webpack_require__(13);

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && navigator.product === 'ReactNative') {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object' && !isArray(obj)) {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = merge(result[key], val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  extend: extend,
  trim: trim
};


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(0);
var normalizeHeaderName = __webpack_require__(15);

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(4);
  } else if (typeof process !== 'undefined') {
    // For node use HTTP adapter
    adapter = __webpack_require__(4);
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(8)))

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(12);

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var settle = __webpack_require__(16);
var buildURL = __webpack_require__(18);
var parseHeaders = __webpack_require__(19);
var isURLSameOrigin = __webpack_require__(20);
var createError = __webpack_require__(5);
var btoa = (typeof window !== 'undefined' && window.btoa && window.btoa.bind(window)) || __webpack_require__(21);

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();
    var loadEvent = 'onreadystatechange';
    var xDomain = false;

    // For IE 8/9 CORS support
    // Only supports POST and GET calls and doesn't returns the response headers.
    // DON'T do this for testing b/c XMLHttpRequest is mocked, not XDomainRequest.
    if ("development" !== 'test' &&
        typeof window !== 'undefined' &&
        window.XDomainRequest && !('withCredentials' in request) &&
        !isURLSameOrigin(config.url)) {
      request = new window.XDomainRequest();
      loadEvent = 'onload';
      xDomain = true;
      request.onprogress = function handleProgress() {};
      request.ontimeout = function handleTimeout() {};
    }

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password || '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    request.open(config.method.toUpperCase(), buildURL(config.url, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request[loadEvent] = function handleLoad() {
      if (!request || (request.readyState !== 4 && !xDomain)) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        // IE sends 1223 instead of 204 (https://github.com/mzabriskie/axios/issues/201)
        status: request.status === 1223 ? 204 : request.status,
        statusText: request.status === 1223 ? 'No Content' : request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      reject(createError('timeout of ' + config.timeout + 'ms exceeded', config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      var cookies = __webpack_require__(22);

      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(config.url)) && config.xsrfCookieName ?
          cookies.read(config.xsrfCookieName) :
          undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (config.withCredentials) {
      request.withCredentials = true;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (requestData === undefined) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(17);

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),
/* 8 */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var WebUrl = function () {
    function WebUrl()
    // private url:string
    {
        _classCallCheck(this, WebUrl);

        this.url = 'http://localhost:3000/pogtank/public';
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
/* 10 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_axios__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }



var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var MaterialType = function () {
    function MaterialType() {
        _classCallCheck(this, MaterialType);

        this.url = webUrl.getUrl();
    }
    //Get Material Types


    _createClass(MaterialType, [{
        key: 'getMaterialTypeTree',
        value: function getMaterialTypeTree() {
            var url = this.url + '/admin/materials/types/get_material_type_tree';
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get all types that could be parent

    }, {
        key: 'getMaterialParentTypes',
        value: function getMaterialParentTypes() {
            var url = this.url + '/admin/materials/types/get_material_parent_type';
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.get(url).then(function (result) {
                    resolve(result.data);
                    console.log('Service Get Type :', result);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //get selected material Type

    }, {
        key: 'getMaterialType',
        value: function getMaterialType(id) {
            var url = this.url + '/admin/materials/types/get_material_type/' + id;
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //get parent siblings types

    }, {
        key: 'getMaterialParentSiblingTypes',
        value: function getMaterialParentSiblingTypes(id) {
            var url = this.url + '/admin/materials/types/get_material_parent_sibling_types/' + id;
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return MaterialType;
}();

/* harmony default export */ __webpack_exports__["a"] = (MaterialType);

/***/ }),
/* 11 */,
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var bind = __webpack_require__(3);
var Axios = __webpack_require__(14);
var defaults = __webpack_require__(1);

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(utils.merge(defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(7);
axios.CancelToken = __webpack_require__(28);
axios.isCancel = __webpack_require__(6);

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(29);

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),
/* 13 */
/***/ (function(module, exports) {

/*!
 * Determine if an object is a Buffer
 *
 * @author   Feross Aboukhadijeh <https://feross.org>
 * @license  MIT
 */

// The _isBuffer check is for Safari 5-7 support, because it's missing
// Object.prototype.constructor. Remove this eventually
module.exports = function (obj) {
  return obj != null && (isBuffer(obj) || isSlowBuffer(obj) || !!obj._isBuffer)
}

function isBuffer (obj) {
  return !!obj.constructor && typeof obj.constructor.isBuffer === 'function' && obj.constructor.isBuffer(obj)
}

// For Node v0.10 support. Remove this eventually.
function isSlowBuffer (obj) {
  return typeof obj.readFloatLE === 'function' && typeof obj.slice === 'function' && isBuffer(obj.slice(0, 0))
}


/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var defaults = __webpack_require__(1);
var utils = __webpack_require__(0);
var InterceptorManager = __webpack_require__(23);
var dispatchRequest = __webpack_require__(24);
var isAbsoluteURL = __webpack_require__(26);
var combineURLs = __webpack_require__(27);

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = utils.merge({
      url: arguments[0]
    }, arguments[1]);
  }

  config = utils.merge(defaults, this.defaults, { method: 'get' }, config);
  config.method = config.method.toLowerCase();

  // Support baseURL config
  if (config.baseURL && !isAbsoluteURL(config.url)) {
    config.url = combineURLs(config.baseURL, config.url);
  }

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(5);

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  // Note: status is not exposed by XDomainRequest
  if (!response.status || !validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }
  error.request = request;
  error.response = response;
  return error;
};


/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

function encode(val) {
  return encodeURIComponent(val).
    replace(/%40/gi, '@').
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      }

      if (!utils.isArray(val)) {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
    }
  });

  return parsed;
};


/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  (function standardBrowserEnv() {
    var msie = /(msie|trident)/i.test(navigator.userAgent);
    var urlParsingNode = document.createElement('a');
    var originURL;

    /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
    function resolveURL(url) {
      var href = url;

      if (msie) {
        // IE needs attribute set twice to normalize properties
        urlParsingNode.setAttribute('href', href);
        href = urlParsingNode.href;
      }

      urlParsingNode.setAttribute('href', href);

      // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
      return {
        href: urlParsingNode.href,
        protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
        host: urlParsingNode.host,
        search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
        hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
        hostname: urlParsingNode.hostname,
        port: urlParsingNode.port,
        pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
                  urlParsingNode.pathname :
                  '/' + urlParsingNode.pathname
      };
    }

    originURL = resolveURL(window.location.href);

    /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
    return function isURLSameOrigin(requestURL) {
      var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
      return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
    };
  })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return function isURLSameOrigin() {
      return true;
    };
  })()
);


/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// btoa polyfill for IE<10 courtesy https://github.com/davidchambers/Base64.js

var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

function E() {
  this.message = 'String contains an invalid character';
}
E.prototype = new Error;
E.prototype.code = 5;
E.prototype.name = 'InvalidCharacterError';

function btoa(input) {
  var str = String(input);
  var output = '';
  for (
    // initialize result and counter
    var block, charCode, idx = 0, map = chars;
    // if the next str index does not exist:
    //   change the mapping table to "="
    //   check if d has no fractional digits
    str.charAt(idx | 0) || (map = '=', idx % 1);
    // "8 - idx % 1 * 8" generates the sequence 2, 4, 6, 8
    output += map.charAt(63 & block >> 8 - idx % 1 * 8)
  ) {
    charCode = str.charCodeAt(idx += 3 / 4);
    if (charCode > 0xFF) {
      throw new E();
    }
    block = block << 8 | charCode;
  }
  return output;
}

module.exports = btoa;


/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
  (function standardBrowserEnv() {
    return {
      write: function write(name, value, expires, path, domain, secure) {
        var cookie = [];
        cookie.push(name + '=' + encodeURIComponent(value));

        if (utils.isNumber(expires)) {
          cookie.push('expires=' + new Date(expires).toGMTString());
        }

        if (utils.isString(path)) {
          cookie.push('path=' + path);
        }

        if (utils.isString(domain)) {
          cookie.push('domain=' + domain);
        }

        if (secure === true) {
          cookie.push('secure');
        }

        document.cookie = cookie.join('; ');
      },

      read: function read(name) {
        var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
        return (match ? decodeURIComponent(match[3]) : null);
      },

      remove: function remove(name) {
        this.write(name, '', Date.now() - 86400000);
      }
    };
  })() :

  // Non standard browser env (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return {
      write: function write() {},
      read: function read() { return null; },
      remove: function remove() {}
    };
  })()
);


/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var transformData = __webpack_require__(25);
var isCancel = __webpack_require__(6);
var defaults = __webpack_require__(1);

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers || {}
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(7);

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),
/* 30 */,
/* 31 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__webUrl__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_axios__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }



var webUrl = new __WEBPACK_IMPORTED_MODULE_0__webUrl__["a" /* default */]();

var MaterialItem = function () {
    function MaterialItem() {
        _classCallCheck(this, MaterialItem);

        this.url = webUrl.getUrl();
    }
    //Add Local Prices


    _createClass(MaterialItem, [{
        key: 'addLocalPrices',
        value: function addLocalPrices(formInputs) {
            var url = this.url + '/admin/materials/items/add_local_prices';
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.post(url, formInputs).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get Material Item

    }, {
        key: 'getItem',
        value: function getItem(materialID) {
            var url = this.url + '/admin/materials/items/edit/global_details/' + materialID;
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //get Approved Local Price

    }, {
        key: 'getApprovedLocalPrice',
        value: function getApprovedLocalPrice(materialID) {
            var url = this.url + '/admin/materials/items/edit/' + materialID + '/approved_local_prices';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Get Waiting Local Price

    }, {
        key: 'getWaitingLocalPrices',
        value: function getWaitingLocalPrices(materialID) {
            var url = this.url + '/admin/materials/items/edit/' + materialID + '/waiting_local_prices';
            return new Promise(function (resolve, reject) {
                axios.get(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //update Global Details Values

    }, {
        key: 'updateGlobalDetails',
        value: function updateGlobalDetails(inputData) {
            var url = this.url + '/admin/materials/items/update_global_details';
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.put(url, inputData).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Update Local Price Details

    }, {
        key: 'updateLocalPriceDetails',
        value: function updateLocalPriceDetails(inputData, id) {
            var url = this.url + '/admin/materials/items/update_local_price_details/' + id;
            // let url=this.url+'/test';
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.put(url, inputData).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Delete Local Price

    }, {
        key: 'deleteLocalPrice',
        value: function deleteLocalPrice(id) {
            var url = this.url + '/admin/materials/items/delete_local_price/' + id;
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.delete(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
        //Delete Waiting Local Price

    }, {
        key: 'deleteWaitingLocalPrice',
        value: function deleteWaitingLocalPrice(id) {
            var url = this.url + '/admin/materials/items/delete_waiting_local_price/' + id;
            return new Promise(function (resolve, reject) {
                __WEBPACK_IMPORTED_MODULE_1_axios___default.a.delete(url).then(function (result) {
                    resolve(result.data);
                }).catch(function (err) {
                    reject(err);
                });
            });
        }
    }]);

    return MaterialItem;
}();

/* harmony default export */ __webpack_exports__["a"] = (MaterialItem);

/***/ }),
/* 32 */,
/* 33 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__webUrl__ = __webpack_require__(9);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }



var webUrl = new __WEBPACK_IMPORTED_MODULE_1__webUrl__["a" /* default */]();

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
                __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get(_this.webUrl + '/admin/materials/city/provinces').then(function (result) {
                    resolve(result.data);
                    console.log(result);
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
                __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get(url).then(function (result) {
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
                __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get(url).then(function (result) {
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
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */,
/* 42 */,
/* 43 */,
/* 44 */,
/* 45 */,
/* 46 */,
/* 47 */,
/* 48 */,
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */,
/* 63 */,
/* 64 */,
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(66);
__webpack_require__(67);
__webpack_require__(70);
__webpack_require__(71);
module.exports = __webpack_require__(72);


/***/ }),
/* 66 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_city__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_material_material_type_service__ = __webpack_require__(10);



var dict = {
    custom: {
        materialName: { required: 'ชื่อสินค้า' },
        materialTypeID: { required: 'หมวดหมู่' },
        materialUnit: { required: 'หน่วย' },
        province: { required: 'จังหวัด' },
        amphoe: { required: 'อำเภอ' },
        district: { required: 'ตำบล' }
    }
};
//Created Vue Instance
var vm = new Vue({
    el: '#material-item-create',
    data: {
        show: '',
        city: new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_city__["a" /* default */](),
        materialName: '',
        test: 'abc',
        item: '',
        materialTypes: [],
        provinces: [],
        form: {
            cities: [{
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localCost: 0,
                localPrice: 0,
                wage: 0
            }],
            materialVendor: '',
            materialName: '',
            materialUnit: '',
            materialType: '',
            materialTypeID: '',
            globalCost: 0,
            globalPrice: 0,
            invoiceCost: 0,
            invoicePrice: 0
        },
        displayStatus: []
    },
    created: function created() {},
    //Mounted
    mounted: function mounted() {
        var _this = this;

        console.log('Mounted');
        this.show = true;
        this.$validator.localize('en', dict);
        this.displayStatus.push(false);
        var materialTypes = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_material_material_type_service__["a" /* default */]();
        Promise.all([materialTypes.getMaterialTypeTree() //Get All Materials
        .then(function (result) {
            console.log(result);
            vm.materialTypes = result;
        }).catch(function (err) {}), this.city.getProvinces() // Get Provinces
        .then(function (result) {
            vm.provinces = result;
        }).catch(function (err) {
            console.log(err);
        })]).then(function () {
            _this.show = false;
        }).catch();
    },
    //Methods
    methods: {
        // -- Form Validation
        validateForm: function validateForm(scope, ev) {
            this.$validator.validateAll(scope).then(function (result) {
                var errMassage = 'กรุณาระบุ ';
                if (result) {
                    axios.post('/admin/materials/items', vm.form).then(function (result) {
                        alert('เพิ่มเสร็จแล้ว');
                        // window.location=indexRoute+'/added';
                        console.log(result);
                    }).catch(function (err) {
                        alert('ไม่สามารถเพิ่มข้อมูลได้ลองใหม่อีกครั้ง');
                        console.log(err);
                        console.log('Bad!!');
                    });
                } else {
                    vm.$validator.errors.items.forEach(function (error) {
                        errMassage = errMassage + error.msg + ', ';
                    });
                    alert(errMassage);
                }
            });
        },
        // -- Add more Local Price Input
        addPriceInput: function addPriceInput() {
            var city = {
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localCost: 0,
                localPrice: 0,
                wage: 0
            };
            // let city='';
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

/***/ }),
/* 67 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_item_service__ = __webpack_require__(31);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_material_material_type_service__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__assets_js_services_city__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__item_edit_add_modal__ = __webpack_require__(68);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__item_edit_edit_modal__ = __webpack_require__(69);





var dict = {
    custom: {
        materialName: { required: 'ชื่อสินค้า' },
        materialTypeID: { required: 'ประเภท' },
        materialUnit: { required: 'หน่วย' }
    }
};
var materialItemService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_item_service__["a" /* default */]();
var materialTypeService = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_material_material_type_service__["a" /* default */]();
var path = window.location.pathname;
var materialID = path.split("/").slice(-1);
var cityService = new __WEBPACK_IMPORTED_MODULE_2__assets_js_services_city__["a" /* default */]();
//Initial Data
var vm = new Vue({
    el: '#material-item-edit',
    mixins: [__WEBPACK_IMPORTED_MODULE_3__item_edit_add_modal__["a" /* AddModal */], __WEBPACK_IMPORTED_MODULE_4__item_edit_edit_modal__["a" /* EditModal */]],
    data: {
        addStatus: false,
        updateStatus: false,
        showLoading: '',
        material: {},
        waitingItemNumber: 0,
        item: '',
        materialTypes: [],
        provinces: [],
        //Global Details
        approvedGlobalDetails: {},
        waitingGlobalDetails: {},
        waitingLocalPrices: {},
        approvedLocalPrices: {},
        displayStatus: [],
        checkedWaitingLocalPrices: [],
        form: {
            material_id: '',
            cities: [{
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localCost: 0,
                localPrice: 0,
                wage: 0
            }]
        }
    },
    mounted: function mounted() {
        this.showLoading = true;
        this.initialData();
    },
    //Methods
    methods: {
        //Initial Data
        initialData: function initialData() {
            var _this = this;

            Promise.all([
            //Get Province
            cityService.getProvinces().then(function (result) {
                vm.provinces = result;
            }).catch(function (err) {}),
            //Get Material Types
            materialTypeService.getMaterialTypeTree().then(function (result) {
                _this.materialTypes = result;
            }).catch(function (err) {
                alert(err);
            }),
            //Get Material Item ที่ต้องการแก้ไข
            materialItemService.getItem(materialID).then(function (result) {
                _this.material = result;
                console.log(_this.material);
            }).catch(function (err) {
                console.log(err);
                alert(err);
            }),
            //Get Approved Local Price
            materialItemService.getApprovedLocalPrice(materialID).then(function (result) {
                _this.approvedLocalPrices = result;
            }).catch(function (err) {
                alert(err);
            }), materialItemService.getWaitingLocalPrices(materialID).then(function (result) {
                _this.waitingLocalPrices = result;
            }).catch(function (err) {
                alert(err);
            })]).then(function () {
                _this.showLoading = false;
            });
            // Set config defaults when creating the instance
            this.$validator.localize('en', dict);
            this.displayStatus.push(false);
            console.log(this.$validator);
        },
        refreshData: function refreshData() {
            var _this2 = this;

            this.showLoading = true;
            this.addStatus = false;
            this.updateStatus = false;
            this.resetFormData();
            console.log('Form After Refresh', this.form);
            Promise.all([
            //Get Material Item ที่ต้องการแก้ไข
            materialItemService.getItem(materialID).then(function (result) {
                _this2.material = result;
            }).catch(function (err) {
                console.log(err);
                alert(err);
            }),
            //Get Approved Local Price
            materialItemService.getApprovedLocalPrice(materialID).then(function (result) {
                _this2.approvedLocalPrices = result;
            }).catch(function (err) {
                alert(err);
            }), materialItemService.getWaitingLocalPrices(materialID).then(function (result) {
                _this2.waitingLocalPrices = result;
            }).catch(function (err) {
                alert(err);
            })]).then(function () {
                _this2.showLoading = false;
            });
        },
        resetFormData: function resetFormData() {
            this.form = {
                material_id: '',
                cities: [{
                    province: '',
                    amphoe: '',
                    district: '',
                    amphoes: [],
                    districts: [],
                    localCost: 0,
                    localPrice: 0,
                    wage: 0
                }]
            };
        },
        //Modal
        showAddLocalPriceModal: function showAddLocalPriceModal() {
            console.log('Parent Master', vm);
            this.$modal.show('add-local-price-modal');
        },
        showEditLocalPriceModal: function showEditLocalPriceModal(item, status) {
            console.log('Edit Item', item);
            var data = {};
            if (status === 'approved') {
                data = item.approved_price;
            } else if (status === 'waiting') {
                data = item.waiting_price;
            }
            this.$modal.show('edit-local-price-modal', {
                local_price: data
            });
        },
        beforeClose: function beforeClose(event) {
            console.log('Form', this.form);
            this.resetFormData();
            if (this.addStatus || this.updateStatus) {
                this.refreshData();
            }
        },
        // -- Form Validation
        validateForm: function validateForm(scope, ev) {
            console.log(vm.form.materialID);
            this.$validator.validateAll(scope).then(function (result) {
                var errMassage = 'กรุณาระบุ ';
                if (result) {
                    axios.put('/admin/materials/items/' + vm.form.materialID, vm.form).then(function (result) {
                        console.log(result);
                        // window.location = indexRoute + '/updated'
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
        // -- Get Amphoe
        getAmphoes: function getAmphoes(index) {
            this.form.cities[index].amphoe = ''; // clear old amphoe
            this.form.cities[index].district = ''; //clear old district
            this.form.cities[index].districts.splice(0); // clear district array
            this.form.cities[index].amphoes = this.form.cities[index].province.amphoes;
        },
        // -- Get District
        getDistricts: function getDistricts(index) {
            this.form.cities[index].district = ''; // clear old district
            cityService.getDistricts(this.form.cities[index].amphoe.id).then(function (result) {
                vm.form.cities[index].districts = result;
            }).catch(function (err) {
                alert(err);
            });
        },
        getWaitingLocalPriceResults: function getWaitingLocalPriceResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
            axios.get(this.waitingLocalPriceUrl + '?page=' + page).then(function (result) {
                vm.waitingLocalPrices = result.data;
            }).catch(function (err) {
                console.log(err);
            });
        },
        getApprovedLocalPricesResults: function getApprovedLocalPricesResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
            axios.get(this.waitingLocalPriceUrl + '?page=' + page).then(function (result) {
                vm.waitingLocalPrices = result.data;
            }).catch(function (err) {
                console.log(err);
            });
        },

        deleteLocalPrice: function deleteLocalPrice(item) {
            var _this3 = this;

            console.log('Delete Local Price Item', item);
            materialItemService.deleteLocalPrice(item.approved_price.local_price_id).then(function () {
                _this3.refreshData();
            }).catch(function (err) {
                alert(err);
            });
        },
        deleteWaitingGlobalDetails: function deleteWaitingGlobalDetails(item) {
            var _this4 = this;

            if (confirm('ยืนยันการลบ')) {
                axios.delete('/admin/materials/items/' + item.material_id + '/waiting_global_details/' + item.id).then(function (result) {
                    console.log(result);
                    _this4.waitingGlobalDetails = null;
                    _this4.decreaseWaitingItemNumber(1);
                }).catch(function (err) {
                    console.log(err);
                });
            }
        },
        deleteWaitingLocalPrice: function deleteWaitingLocalPrice(item) {
            var _this5 = this;

            console.log('Delete Waiting Local Price Item :', item);
            if (confirm('ยืนยันการลบ')) {
                materialItemService.deleteWaitingLocalPrice(item.waiting_price.id).then(function () {
                    _this5.refreshData();
                    toastr.success('การลบเสร็จสมบูรณ์');
                }).catch(function (err) {
                    alert(err);
                });
            }
        },
        deleteMultipleWaitingLocalPrices: function deleteMultipleWaitingLocalPrices() {
            var _this6 = this;

            if (confirm('ยืนยันการลบ')) {
                var items = {
                    'waitingLocalPriceIDs': this.checkedWaitingLocalPrices.map(function (item) {
                        return item.id;
                    })
                };
                axios.delete('/admin/materials/items/local_price/' + this.material.id + '/waiting_local_prices', { data: items }).then(function (result) {
                    _this6.getWaitingLocalPrices();
                    _this6.decreaseWaitingItemNumber(1);
                    toastr.success('การลบเสร็จสมบูรณ์');
                }).catch(function (err) {
                    console.log(err);
                });
                console.log(items);
            }
        },
        decreaseWaitingItemNumber: function decreaseWaitingItemNumber(number) {
            this.waitingItemNumber -= number;
        },
        //Approved Global Details ใช้สำหรับอนุมติรายการ รายละเอียดทั่วไป
        updateGlobalDetailsStatus: function updateGlobalDetailsStatus(item) {
            var _this7 = this;

            var inputs = {
                'publishedStatus': 'approved',
                'materialID': item.material_id
            };
            if (confirm('ยืนยันการอนุมัติ')) {
                axios.put('/admin/materials/items/update_global_details_status/' + item.id, inputs).then(function (result) {
                    console.log(result);
                    _this7.refreshData();
                    toastr.success('การอนุมัติเสร็จสมบูรณ์');
                    _this7.waitingGlobalDetails = null;
                    _this7.decreaseWaitingItemNumber(1);
                }).catch(function (err) {
                    console.log(err);
                });
            }
        },
        //ใช้อนุมัติ local price
        updateLocalPriceStatus: function updateLocalPriceStatus() {
            var _this8 = this;

            if (confirm('ยืนยันการอนุมัติ')) {
                var items = {
                    'waitingLocalPriceIDs': this.checkedWaitingLocalPrices.map(function (item) {
                        return item.id;
                    }),
                    'publishedStatus': 'approved'
                };
                axios.put('admin/materials/items/' + this.material.id + '/update_local_price', items).then(function (result) {
                    console.log(result);
                    _this8.refreshData();
                    toastr.success('การอนุมัติเสร็จสมบูรณ์');
                }).catch(function (err) {
                    console.log(err);
                });
            }
        },
        //Update Global Details Value
        updateGlobalDetails: function updateGlobalDetails() {
            var _this9 = this;

            console.log('In Global Details', vm.approvedGlobalDetails);
            materialItemService.updateGlobalDetails(vm.approvedGlobalDetails).then(function (result) {
                toastr.success('อัพเดทเสร็จสมบูรณ์');
                _this9.refreshData();
                console.log('Updated Global Details');
            }).catch(function (err) {
                console.log(err);
            });
        }
    },
    watch: {
        'form.materialType': function formMaterialType() {
            this.form.materialTypeID = this.form.materialType.id;
        },
        material: function material() {
            console.log('In Watch Material:', this.material);
            var count = 0;
            if (this.material.waiting_global_details) {
                count++;
            }
            this.approvedGlobalDetails = this.material.approved_global_details;
            this.waitingGlobalDetails = this.material.waiting_global_details;
            this.waitingItemNumber = count + this.material.waiting_local_prices.length;
        }
    }
});
console.log('Master', vm);

/***/ }),
/* 68 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AddModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_item_service__ = __webpack_require__(31);

var dict = {
    custom: {
        province: { required: 'จังหวัด' },
        amphoe: { required: 'อำเภอ' },
        district: { required: 'ตำบล' }
    }
};
var materialItemService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_item_service__["a" /* default */]();
var AddModal = {
    data: function data() {
        return {};
    },
    mounted: function mounted() {
        this.$validator.localize('en', dict);
    },
    methods: {
        //Add Local Price
        addLocalPrice: function addLocalPrice(scope, ev) {
            var _this = this;

            console.log('Form Event', ev);
            this.$validator.validateAll(scope).then(function (result) {
                var errMassage = 'กรุณาระบุ ';
                if (result) {
                    _this.form.material_id = _this.material.id;
                    materialItemService.addLocalPrices(_this.form).then(function () {
                        _this.addStatus = true;
                        _this.closeAddPriceModal();
                    }).catch(function (err) {
                        alert(err);
                    });
                } else {
                    _this.$validator.errors.items.forEach(function (error) {
                        errMassage = errMassage + error.msg + ', ';
                    });
                    alert(errMassage);
                }
            });
        },
        // -- Add more Local Price Input
        addPriceInput: function addPriceInput() {
            var city = {
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localPrice: 0,
                localCost: 0,
                wage: 0
            };
            this.form.cities.push(city);
        },
        beforeOpen: function beforeOpen(event) {
            console.log('Before Open');
        },
        // Close Add Price Modal
        closeAddPriceModal: function closeAddPriceModal() {
            this.$modal.hide('add-local-price-modal');
        },
        showAddPriceModal: function showAddPriceModal() {
            this.$modal.show('add-local-price-modal');
            // this.$modal.show('add-local-price-modal', {
            // form: this.form,
            // provinces: vm.provinces,
            // material_id: vm.material.id
            // })
        }

    }
};

/***/ }),
/* 69 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return EditModal; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_item_service__ = __webpack_require__(31);

var materialItemService = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_item_service__["a" /* default */]();
var EditModal = {
    data: function data() {
        return {
            form: {
                'local_price_version_id': ''
            }
        };
    },
    mounted: function mounted() {},
    methods: {
        //Add Local Price
        updateLocalPrice: function updateLocalPrice(scope, ev) {
            var _this = this;

            console.log('Update Local Price Details');
            this.$validator.validateAll(scope).then(function (result) {
                var errMassage = 'กรุณาระบุ ';
                if (result) {
                    _this.form.material_id = _this.material.id;
                    materialItemService.updateLocalPriceDetails(_this.form, _this.form.local_price_version_id).then(function (result) {
                        console.log('Update Local Price Result', result);
                        _this.updateStatus = true;
                        toastr.success('อัพเดทเสร็จสมบูรณ์');
                        _this.closeEditPriceModal();
                    }).catch(function (err) {
                        alert(err);
                    });
                } else {
                    _this.$validator.errors.items.forEach(function (error) {
                        errMassage = errMassage + error.msg + ', ';
                    });
                    alert(errMassage);
                }
            });
        },
        // -- Edit more Local Price Input
        beforeEditOpen: function beforeEditOpen(event) {
            var data = event.params.local_price;
            console.log('Edit Modal Data', data);
            this.form = {
                material_id: this.material.id, //Data from parent
                local_price_id: data.local_price_id,
                local_price_version_id: data.id,
                cities: [{
                    province: data.province,
                    amphoe: data.amphoe,
                    district: data.district,
                    amphoes: data.province.amphoes,
                    districts: data.amphoe.districts,
                    localCost: data.cost,
                    localPrice: data.price,
                    wage: data.wage
                }]
            };
            console.log('Form in Edit Modal', this.form);
        },
        // Close Add Price Modal
        closeEditPriceModal: function closeEditPriceModal() {
            this.$modal.hide('edit-local-price-modal');
        }
    }
};

/***/ }),
/* 70 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_type_service__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__assets_js_services_webUrl__ = __webpack_require__(9);
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



//Custom Error Message
var dict = {
    custom: {
        typeName: { required: 'ชื่อหมวดหมู่' },
        parentTypeID: { required: 'ลำดับหมวดหมู่' },
        codePrefix: { required: 'รหัสหมวดหมู่' }
    }
};
var webUrl = new __WEBPACK_IMPORTED_MODULE_1__assets_js_services_webUrl__["a" /* default */]();
var indexRoute = webUrl.getRoute('/admin/materials/types/submitted');
var materialTypes = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_type_service__["a" /* default */]();
var vm = new Vue(_defineProperty({
    el: '#material-type-create',
    //Created
    created: function created() {
        this.$validator.localize('en', dict);
    },
    //Data
    data: {
        showLoading: '',
        parentTypes: [],
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
    mounted: function mounted() {
        var _this = this;

        this.showLoading = true;
        materialTypes.getMaterialParentTypes().then(function (result) {
            vm.parentTypes = result;
            _this.showLoading = false;
        }).catch(function (err) {
            console.log(err);
            _this.showLoading = false;
        });
    },
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

/***/ }),
/* 71 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_type_service__ = __webpack_require__(10);

var dict = {
    custom: {
        typeName: { required: 'ชื่อหมวดหมู่' },
        parentTypeID: { required: 'ลำดับหมวดหมู่' },
        codePrefix: { required: 'รหัสหมวดหมู่' }
    }
};
var path = window.location.pathname;
var typeID = path.split("/").slice(-1);
var materialType = new __WEBPACK_IMPORTED_MODULE_0__assets_js_services_material_material_type_service__["a" /* default */]();
var oldType = {};
var vm = new Vue({
    el: '#material-type-edit',
    //Created
    created: function created() {
        this.$validator.localize('en', dict);
    },
    //Data
    data: {
        showLoading: '',
        parentTypes: [],
        form: {
            name: '',
            parentType: {
                id: '',
                name: ''
            },
            details: '',
            codePrefix: '',
            parentTypeID: ''
        }
    },
    mounted: function mounted() {
        this.showLoading = true;

        Promise.all([
        //Get Old Types
        materialType.getMaterialType(typeID).then(function (oldType) {
            console.log(oldType);
            vm.form = {
                name: oldType.name,
                parentType: {
                    id: oldType.ancestors[0] ? oldType.ancestors[0].id : 0,
                    name: oldType.ancestors[0] ? oldType.ancestors[0].name : 'หมวดหมู่หลัก'
                },
                details: oldType.details,
                codePrefix: oldType.code_prefix,
                parentTypeID: oldType.ancestors[0] ? oldType.ancestors[0].id : 0
            };
        }).catch(function (err) {
            console.log(err);
        }),
        //Get all Parent and Sibling Types
        materialType.getMaterialParentSiblingTypes(typeID).then(function (result) {
            vm.parentTypes = result;
            console.log(result);
        }).catch(function (err) {
            console.log(err);
        })]).then(function () {
            vm.showLoading = false;
        });
    },
    methods: {
        validateForm: function validateForm(scope) {
            this.$validator.validateAll(scope).then(function (result) {
                if (result) {
                    axios.put('/admin/materials/types/' + oldType.id, vm.form).then(function (result) {
                        window.location = indexRoute;
                    }).catch(function (err) {
                        console.log(err);
                        alert('ไม่สามารถเพิ่มข้อมูลได้กรุณารองใหม่อีกครั้ง');
                    });
                }
            });
        }
    },
    watch: {
        'form.parentType': function formParentType() {
            this.form.parentTypeID = this.form.parentType.id;
        }
    }
});

/***/ }),
/* 72 */
/***/ (function(module, exports) {



/***/ })
/******/ ]);