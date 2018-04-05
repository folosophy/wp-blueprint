'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

jQuery(document).ready(function ($) {
  var BpSlider = function () {
    function BpSlider() {
      _classCallCheck(this, BpSlider);

      this.watch();
      this.watchToggle();
    }

    _createClass(BpSlider, [{
      key: 'watch',
      value: function watch() {
        var $navItem = $('.bp-slider__nav__item');
        $navItem.click(function () {
          var $that = $(this),
              $slider = $(this).closest('.bp-slider'),
              $item = $slider.find('.bp-slider__item'),
              $nav = $slider.find('.bp-slider__nav'),
              $navItem = $slider.find('.bp-slider__nav__item'),
              $next = $that.next(),
              $slides = $slider.find('.bp-slider__items'),
              id = $that.attr('item-id');
          $navItem.removeClass('active');
          $that.addClass('active');
          $item.removeClass('active');
          $slider.find('.bp-slider__item[item-id="' + id + '"]').addClass('active');
          console.log($('.bp-slider__item[item-id="' + id + '"]').length);
        });
      }
    }, {
      key: 'watchToggle',
      value: function watchToggle() {
        var $toggle = $('.bp-slide__toggle');
        $toggle.click(function () {
          var $that = $(this),
              $slide = $that.closest('.bp-slider__item');
          $slide.find('.bp-slide__excerpt').hide();
          $slide.find('.bp-slide__full-quote').show();
        });
      }
    }]);

    return BpSlider;
  }();

  new BpSlider();
}); // End jQuery