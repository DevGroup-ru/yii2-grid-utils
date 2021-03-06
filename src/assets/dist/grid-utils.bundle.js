/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Editable = function () {
  function Editable(options) {
    _classCallCheck(this, Editable);

    this.settings = options;

    this.bindListeners();
  }

  _createClass(Editable, [{
    key: 'bindListeners',
    value: function bindListeners() {
      var that = this;
      $(document).on('change', this.settings.selector, function () {
        var $obj = $(this);
        $obj.addClass('highlight-changes');
        var route = $obj.data('route');
        var id = $obj.data('id');
        var attribute = $obj.data('attribute');
        var value = $obj.val();
        console.log($obj);
        $.ajax({
          url: route,
          method: 'post',
          dataType: 'json',
          cache: false,
          data: {
            id: id,
            attribute: attribute,
            value: value,
            _csrf: $('meta[name="csrf-token"]').attr('content')
          },
          success: function success(result) {
            if (result) {
              that.showOk($obj);
            } else {
              that.showError($obj);
            }
          },
          error: function error() {
            that.showError($obj);
          }
        });
      });
    }
  }, {
    key: 'showOk',
    value: function showOk($obj) {
      $obj.addClass('highlight-changes_ok');
      setTimeout(function () {
        $obj.removeClass('highlight-changes').removeClass('highlight-changes_ok');
      }, 500);
      if (window.gridUtilsEditableSuccessCallback) {
        window.gridUtilsEditableSuccessCallback();
      }
    }
  }, {
    key: 'showError',
    value: function showError($obj) {
      $obj.addClass('highlight-changes_error');
      setTimeout(function () {
        $obj.removeClass('highlight-changes').removeClass('highlight-changes_error');
      }, 1500);
    }
  }]);

  return Editable;
}();

exports.default = Editable;

/***/ }),
/* 1 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

__webpack_require__(1);

var _Editable = __webpack_require__(0);

var _Editable2 = _interopRequireDefault(_Editable);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var GridUtils = function () {
  function GridUtils() {
    _classCallCheck(this, GridUtils);

    this.init();
  }

  _createClass(GridUtils, [{
    key: 'init',
    value: function init() {
      var userSettings = window.GridUtilsSettings || {};
      var settings = {
        editableOptions: {
          selector: '.grid-input'
        }
      };
      Object.keys(userSettings).forEach(function (key) {
        settings[key] = userSettings[key];
      });
      this.settings = settings;

      this.Editable = new _Editable2.default(this.settings.editableOptions);
    }
  }]);

  return GridUtils;
}();

window.GridUtils = new GridUtils();

/***/ })
/******/ ]);
//# sourceMappingURL=grid-utils.bundle.js.map