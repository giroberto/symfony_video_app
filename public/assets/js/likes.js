(self["webpackChunk"] = self["webpackChunk"] || []).push([["js/likes"],{

/***/ "./assets/js/likes.js":
/*!****************************!*\
  !*** ./assets/js/likes.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
__webpack_require__(/*! core-js/modules/es.parse-int.js */ "./node_modules/core-js/modules/es.parse-int.js");

__webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");

__webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");

$(document).ready(function () {
  $('.userLikesVideo').show();
  $('.userDislikesVideo').show();
  $('.noActionYet').show();
  console.log("DOCUMENT READY");
});
$('.toggle-likes').on('click', function (e) {
  e.preventDefault();
  var $link = $(e.currentTarget);
  $.ajax({
    method: 'POST',
    url: $link.attr('href')
  }).done(function (data) {
    switch (data.action) {
      case 'liked':
        var number_of_likes_str = $('.number-of-likes-' + data.id);
        var number_of_likes = parseInt(number_of_likes_str.html().replace(/\D/g, '')) + 1;
        number_of_likes_str.html('(' + number_of_likes + ')');
        $('.likes-video-id-' + data.id).show();
        $('.dislikes-video-id-' + data.id).hide();
        $('.video-id-' + data.id).hide();
        break;

      case 'disliked':
        var number_of_dislikes_str = $('.number-of-dislikes-' + data.id);
        var number_of_dislikes = parseInt(number_of_dislikes_str.html().replace(/\D/g, '')) + 1;
        number_of_dislikes_str.html('(' + number_of_dislikes + ')');
        $('.dislikes-video-id-' + data.id).show();
        $('.likes-video-id-' + data.id).hide();
        $('.video-id-' + data.id).hide();
        break;

      case 'undo liked':
        var number_of_likes_str = $('.number-of-likes-' + data.id);
        var number_of_likes = parseInt(number_of_likes_str.html().replace(/\D/g, '')) - 1;
        number_of_likes_str.html('(' + number_of_likes + ')');
        $('.video-id-' + data.id).show();
        $('.likes-video-id-' + data.id).hide();
        $('.dislikes-video-id-' + data.id).hide();
        break;

      case 'undo disliked':
        var number_of_dislikes_str = $('.number-of-dislikes-' + data.id);
        var number_of_dislikes = parseInt(number_of_dislikes_str.html().replace(/\D/g, '')) - 1;
        number_of_dislikes_str.html('(' + number_of_dislikes + ')');
        $('.video-id-' + data.id).show();
        $('.dislikes-video-id-' + data.id).hide();
        $('.likes-video-id-' + data.id).hide();
        break;
    }
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ "use strict";
/******/ 
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_parse-int_js-node_modules_core-js_modules_es_string_r-729bee"], () => (__webpack_exec__("./assets/js/likes.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbGlrZXMuanMiXSwibmFtZXMiOlsiJCIsImRvY3VtZW50IiwicmVhZHkiLCJzaG93IiwiY29uc29sZSIsImxvZyIsIm9uIiwiZSIsInByZXZlbnREZWZhdWx0IiwiJGxpbmsiLCJjdXJyZW50VGFyZ2V0IiwiYWpheCIsIm1ldGhvZCIsInVybCIsImF0dHIiLCJkb25lIiwiZGF0YSIsImFjdGlvbiIsIm51bWJlcl9vZl9saWtlc19zdHIiLCJpZCIsIm51bWJlcl9vZl9saWtlcyIsInBhcnNlSW50IiwiaHRtbCIsInJlcGxhY2UiLCJoaWRlIiwibnVtYmVyX29mX2Rpc2xpa2VzX3N0ciIsIm51bWJlcl9vZl9kaXNsaWtlcyJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7O0FBQUFBLENBQUMsQ0FBQ0MsUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBWTtBQUMxQkYsR0FBQyxDQUFDLGlCQUFELENBQUQsQ0FBcUJHLElBQXJCO0FBQ0FILEdBQUMsQ0FBQyxvQkFBRCxDQUFELENBQXdCRyxJQUF4QjtBQUNBSCxHQUFDLENBQUMsY0FBRCxDQUFELENBQWtCRyxJQUFsQjtBQUNBQyxTQUFPLENBQUNDLEdBQVIsQ0FBWSxnQkFBWjtBQUNILENBTEQ7QUFPQUwsQ0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQk0sRUFBbkIsQ0FBc0IsT0FBdEIsRUFBK0IsVUFBVUMsQ0FBVixFQUFhO0FBQ3hDQSxHQUFDLENBQUNDLGNBQUY7QUFDQSxNQUFJQyxLQUFLLEdBQUdULENBQUMsQ0FBQ08sQ0FBQyxDQUFDRyxhQUFILENBQWI7QUFDQVYsR0FBQyxDQUFDVyxJQUFGLENBQU87QUFDSEMsVUFBTSxFQUFFLE1BREw7QUFFSEMsT0FBRyxFQUFFSixLQUFLLENBQUNLLElBQU4sQ0FBVyxNQUFYO0FBRkYsR0FBUCxFQUdHQyxJQUhILENBR1EsVUFBVUMsSUFBVixFQUFnQjtBQUNwQixZQUFRQSxJQUFJLENBQUNDLE1BQWI7QUFDSSxX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dGVudCI6WyIkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbiAoKSB7XHJcbiAgICAkKCcudXNlckxpa2VzVmlkZW8nKS5zaG93KCk7XHJcbiAgICAkKCcudXNlckRpc2xpa2VzVmlkZW8nKS5zaG93KCk7XHJcbiAgICAkKCcubm9BY3Rpb25ZZXQnKS5zaG93KCk7XHJcbiAgICBjb25zb2xlLmxvZyhcIkRPQ1VNRU5UIFJFQURZXCIpXHJcbn0pO1xyXG5cclxuJCgnLnRvZ2dsZS1saWtlcycpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICB2YXIgJGxpbmsgPSAkKGUuY3VycmVudFRhcmdldCk7XHJcbiAgICAkLmFqYXgoe1xyXG4gICAgICAgIG1ldGhvZDogJ1BPU1QnLFxyXG4gICAgICAgIHVybDogJGxpbmsuYXR0cignaHJlZicpXHJcbiAgICB9KS5kb25lKGZ1bmN0aW9uIChkYXRhKSB7XHJcbiAgICAgICAgc3dpdGNoIChkYXRhLmFjdGlvbikge1xyXG4gICAgICAgICAgICBjYXNlICdsaWtlZCc6XHJcbiAgICAgICAgICAgICAgICB2YXIgbnVtYmVyX29mX2xpa2VzX3N0ciA9ICQoJy5udW1iZXItb2YtbGlrZXMtJyArIGRhdGEuaWQpO1xyXG4gICAgICAgICAgICAgICAgdmFyIG51bWJlcl9vZl9saWtlcyA9IHBhcnNlSW50KG51bWJlcl9vZl9saWtlc19zdHIuaHRtbCgpLnJlcGxhY2UoL1xcRC9nLCAnJykpICsgMTtcclxuICAgICAgICAgICAgICAgIG51bWJlcl9vZl9saWtlc19zdHIuaHRtbCgnKCcgKyBudW1iZXJfb2ZfbGlrZXMgKyAnKScpO1xyXG4gICAgICAgICAgICAgICAgJCgnLmxpa2VzLXZpZGVvLWlkLScgKyBkYXRhLmlkKS5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICAkKCcuZGlzbGlrZXMtdmlkZW8taWQtJyArIGRhdGEuaWQpLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgICQoJy52aWRlby1pZC0nICsgZGF0YS5pZCkuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJ2Rpc2xpa2VkJzpcclxuICAgICAgICAgICAgICAgIHZhciBudW1iZXJfb2ZfZGlzbGlrZXNfc3RyID0gJCgnLm51bWJlci1vZi1kaXNsaWtlcy0nICsgZGF0YS5pZCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgbnVtYmVyX29mX2Rpc2xpa2VzID0gcGFyc2VJbnQobnVtYmVyX29mX2Rpc2xpa2VzX3N0ci5odG1sKCkucmVwbGFjZSgvXFxEL2csICcnKSkgKyAxO1xyXG4gICAgICAgICAgICAgICAgbnVtYmVyX29mX2Rpc2xpa2VzX3N0ci5odG1sKCcoJyArIG51bWJlcl9vZl9kaXNsaWtlcyArICcpJyk7XHJcbiAgICAgICAgICAgICAgICAkKCcuZGlzbGlrZXMtdmlkZW8taWQtJyArIGRhdGEuaWQpLnNob3coKTtcclxuICAgICAgICAgICAgICAgICQoJy5saWtlcy12aWRlby1pZC0nICsgZGF0YS5pZCkuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgJCgnLnZpZGVvLWlkLScgKyBkYXRhLmlkKS5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAndW5kbyBsaWtlZCc6XHJcbiAgICAgICAgICAgICAgICB2YXIgbnVtYmVyX29mX2xpa2VzX3N0ciA9ICQoJy5udW1iZXItb2YtbGlrZXMtJyArIGRhdGEuaWQpO1xyXG4gICAgICAgICAgICAgICAgdmFyIG51bWJlcl9vZl9saWtlcyA9IHBhcnNlSW50KG51bWJlcl9vZl9saWtlc19zdHIuaHRtbCgpLnJlcGxhY2UoL1xcRC9nLCAnJykpIC0gMTtcclxuICAgICAgICAgICAgICAgIG51bWJlcl9vZl9saWtlc19zdHIuaHRtbCgnKCcgKyBudW1iZXJfb2ZfbGlrZXMgKyAnKScpO1xyXG4gICAgICAgICAgICAgICAgJCgnLnZpZGVvLWlkLScgKyBkYXRhLmlkKS5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICAkKCcubGlrZXMtdmlkZW8taWQtJyArIGRhdGEuaWQpLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgICQoJy5kaXNsaWtlcy12aWRlby1pZC0nICsgZGF0YS5pZCkuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJ3VuZG8gZGlzbGlrZWQnOlxyXG4gICAgICAgICAgICAgICAgdmFyIG51bWJlcl9vZl9kaXNsaWtlc19zdHIgPSAkKCcubnVtYmVyLW9mLWRpc2xpa2VzLScgKyBkYXRhLmlkKTtcclxuICAgICAgICAgICAgICAgIHZhciBudW1iZXJfb2ZfZGlzbGlrZXMgPSBwYXJzZUludChudW1iZXJfb2ZfZGlzbGlrZXNfc3RyLmh0bWwoKS5yZXBsYWNlKC9cXEQvZywgJycpKSAtIDE7XHJcbiAgICAgICAgICAgICAgICBudW1iZXJfb2ZfZGlzbGlrZXNfc3RyLmh0bWwoJygnICsgbnVtYmVyX29mX2Rpc2xpa2VzICsgJyknKTtcclxuICAgICAgICAgICAgICAgICQoJy52aWRlby1pZC0nICsgZGF0YS5pZCkuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgJCgnLmRpc2xpa2VzLXZpZGVvLWlkLScgKyBkYXRhLmlkKS5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICAkKCcubGlrZXMtdmlkZW8taWQtJyArIGRhdGEuaWQpLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgIH1cclxuICAgIH0pO1xyXG59KTsiXSwic291cmNlUm9vdCI6IiJ9