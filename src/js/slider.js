jQuery(document).ready(function($) {

class BpSlider {



  constructor() {
    this.watch();
    this.watchToggle();
  }

  watch() {
    var $navItem = $('.bp-slider__nav__item');
    $navItem.click(function() {
      var $that     = $(this),
          $slider   = $(this).closest('.bp-slider'),
          $item     = $slider.find('.bp-slider__item'),
          $nav      = $slider.find('.bp-slider__nav'),
          $navItem  = $slider.find('.bp-slider__nav__item'),
          $next     = $that.next(),
          $slides   = $slider.find('.bp-slider__items'),
          id        = $that.attr('item-id');
      $navItem.removeClass('active');
      $that.addClass('active');
      $item.removeClass('active');
      $slider.find('.bp-slider__item[item-id="' + id + '"]').addClass('active');
      console.log($('.bp-slider__item[item-id="' + id + '"]').length);
    });
  }

  watchToggle() {
    var $toggle = $('.bp-slide__toggle');
    $toggle.click(function() {
      var $that  = $(this),
          $slide = $that.closest('.bp-slider__item');
      $slide.find('.bp-slide__excerpt').hide();
      $slide.find('.bp-slide__full-quote').show();
    });
  }

}

new BpSlider();

}); // End jQuery
