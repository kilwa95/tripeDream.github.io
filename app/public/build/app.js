(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/app.css */ "./assets/styles/app.css");
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_styles_app_css__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var bootstrap_dist_css_bootstrap_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! bootstrap/dist/css/bootstrap.min.css */ "./node_modules/bootstrap/dist/css/bootstrap.min.css");
/* harmony import */ var bootstrap_dist_css_bootstrap_min_css__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(bootstrap_dist_css_bootstrap_min_css__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_3__);



__webpack_require__(/*! @fortawesome/fontawesome-free/css/all.min.css */ "./node_modules/@fortawesome/fontawesome-free/css/all.min.css");

__webpack_require__(/*! @fortawesome/fontawesome-free/js/all.js */ "./node_modules/@fortawesome/fontawesome-free/js/all.js");




if (jquery__WEBPACK_IMPORTED_MODULE_3___default()(window).width() > 992) {
  jquery__WEBPACK_IMPORTED_MODULE_3___default()(window).scroll(function () {
    if (jquery__WEBPACK_IMPORTED_MODULE_3___default()(this).scrollTop() > 40) {
      jquery__WEBPACK_IMPORTED_MODULE_3___default()('#navbar_top').addClass("fixed-top"); // add padding top to show content behind navbar

      jquery__WEBPACK_IMPORTED_MODULE_3___default()('body').css('padding-top', jquery__WEBPACK_IMPORTED_MODULE_3___default()('.navbar').outerHeight() + 'px');
    } else {
      jquery__WEBPACK_IMPORTED_MODULE_3___default()('#navbar_top').removeClass("fixed-top"); // remove padding top from body

      jquery__WEBPACK_IMPORTED_MODULE_3___default()('body').css('padding-top', '0');
    }
  });
} // end if


jquery__WEBPACK_IMPORTED_MODULE_3___default()(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});
jquery__WEBPACK_IMPORTED_MODULE_3___default()(".animated").addClass("delay-1s");

/***/ }),

/***/ "./assets/styles/app.css":
/*!*******************************!*\
  !*** ./assets/styles/app.css ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ })

},[["./assets/app.js","runtime","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLmNzcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsIndpbmRvdyIsIndpZHRoIiwic2Nyb2xsIiwic2Nyb2xsVG9wIiwiYWRkQ2xhc3MiLCJjc3MiLCJvdXRlckhlaWdodCIsInJlbW92ZUNsYXNzIiwiZG9jdW1lbnQiLCJvbiIsImUiLCJzdG9wUHJvcGFnYXRpb24iXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBOztBQUNBQSxtQkFBTyxDQUFDLG1IQUFELENBQVA7O0FBQ0FBLG1CQUFPLENBQUMsdUdBQUQsQ0FBUDs7QUFDQTtBQUVDOztBQUVELElBQUlDLDZDQUFDLENBQUNDLE1BQUQsQ0FBRCxDQUFVQyxLQUFWLEtBQW9CLEdBQXhCLEVBQTZCO0FBQ3pCRiwrQ0FBQyxDQUFDQyxNQUFELENBQUQsQ0FBVUUsTUFBVixDQUFpQixZQUFVO0FBQ3hCLFFBQUlILDZDQUFDLENBQUMsSUFBRCxDQUFELENBQVFJLFNBQVIsS0FBc0IsRUFBMUIsRUFBOEI7QUFDM0JKLG1EQUFDLENBQUMsYUFBRCxDQUFELENBQWlCSyxRQUFqQixDQUEwQixXQUExQixFQUQyQixDQUUzQjs7QUFDQUwsbURBQUMsQ0FBQyxNQUFELENBQUQsQ0FBVU0sR0FBVixDQUFjLGFBQWQsRUFBNkJOLDZDQUFDLENBQUMsU0FBRCxDQUFELENBQWFPLFdBQWIsS0FBNkIsSUFBMUQ7QUFDRCxLQUpGLE1BSU07QUFDSFAsbURBQUMsQ0FBQyxhQUFELENBQUQsQ0FBaUJRLFdBQWpCLENBQTZCLFdBQTdCLEVBREcsQ0FFRjs7QUFDRFIsbURBQUMsQ0FBQyxNQUFELENBQUQsQ0FBVU0sR0FBVixDQUFjLGFBQWQsRUFBNkIsR0FBN0I7QUFDRDtBQUNKLEdBVkQ7QUFXRCxDLENBQUM7OztBQUdGTiw2Q0FBQyxDQUFDUyxRQUFELENBQUQsQ0FBWUMsRUFBWixDQUFlLE9BQWYsRUFBd0IsZ0JBQXhCLEVBQTBDLFVBQVVDLENBQVYsRUFBYTtBQUNyREEsR0FBQyxDQUFDQyxlQUFGO0FBQ0QsQ0FGRDtBQUlBWiw2Q0FBQyxDQUFDLFdBQUQsQ0FBRCxDQUFlSyxRQUFmLENBQXdCLFVBQXhCLEU7Ozs7Ozs7Ozs7O0FDM0JGLHVDIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCAnLi9zdHlsZXMvYXBwLmNzcyc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9kaXN0L2Nzcy9ib290c3RyYXAubWluLmNzcyc7XG5yZXF1aXJlKCdAZm9ydGF3ZXNvbWUvZm9udGF3ZXNvbWUtZnJlZS9jc3MvYWxsLm1pbi5jc3MnKTtcbnJlcXVpcmUoJ0Bmb3J0YXdlc29tZS9mb250YXdlc29tZS1mcmVlL2pzL2FsbC5qcycpO1xuaW1wb3J0ICdib290c3RyYXAnO1xuXG4gaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcblxuaWYgKCQod2luZG93KS53aWR0aCgpID4gOTkyKSB7XG4gICAgJCh3aW5kb3cpLnNjcm9sbChmdW5jdGlvbigpeyAgXG4gICAgICAgaWYgKCQodGhpcykuc2Nyb2xsVG9wKCkgPiA0MCkge1xuICAgICAgICAgICQoJyNuYXZiYXJfdG9wJykuYWRkQ2xhc3MoXCJmaXhlZC10b3BcIik7XG4gICAgICAgICAgLy8gYWRkIHBhZGRpbmcgdG9wIHRvIHNob3cgY29udGVudCBiZWhpbmQgbmF2YmFyXG4gICAgICAgICAgJCgnYm9keScpLmNzcygncGFkZGluZy10b3AnLCAkKCcubmF2YmFyJykub3V0ZXJIZWlnaHQoKSArICdweCcpO1xuICAgICAgICB9ZWxzZXtcbiAgICAgICAgICAkKCcjbmF2YmFyX3RvcCcpLnJlbW92ZUNsYXNzKFwiZml4ZWQtdG9wXCIpO1xuICAgICAgICAgICAvLyByZW1vdmUgcGFkZGluZyB0b3AgZnJvbSBib2R5XG4gICAgICAgICAgJCgnYm9keScpLmNzcygncGFkZGluZy10b3AnLCAnMCcpO1xuICAgICAgICB9ICAgXG4gICAgfSk7XG4gIH0gLy8gZW5kIGlmXG5cblxuICAkKGRvY3VtZW50KS5vbignY2xpY2snLCAnLmRyb3Bkb3duLW1lbnUnLCBmdW5jdGlvbiAoZSkge1xuICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gIH0pO1xuXG4gICQoXCIuYW5pbWF0ZWRcIikuYWRkQ2xhc3MoXCJkZWxheS0xc1wiKTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW4iXSwic291cmNlUm9vdCI6IiJ9