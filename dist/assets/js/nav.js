'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

jQuery(document).ready(function ($) {

  function fsyMobileNav() {

    var $ham = $('.menu-main__toggle'),
        $exit = $('.menu-mobile__exit'),
        $body = $('body'),
        $nav = $('.nav-main'),
        $navAnchor = $nav.find('a[href^="#"]'),
        $mobileMenu = $('.menu-mobile'),
        ls = $body.scrollTop(),
        mbOpen = 'menu-mobile--is-open',
        nmvHid = 'nav-main--is-hidden';
    // Toggle mobile menu on click
    $ham.click(function () {
      $body.toggleClass(mbOpen);
    });
    $exit.on('click', function () {
      $body.removeClass(mbOpen);
    });
    $navAnchor.click(function () {
      $body.removeClass(mbOpen);
    });
    // Hide/show main nav on scroll
    $(document).scroll(function () {
      var st = $body.scrollTop();
      if (st < 300) {
        $body.addClass(nmvHid);
      }
      ls = st;
    });
  }fsyMobileNav();

  function fsyAnchorScroll() {

    var $anchor = $('a[href^="#"]');
    $anchor.on('click', function (e) {
      e.preventDefault();
      var $that = $(this),
          $target = $($that.attr('href'));
      if ($that.attr('href') == '#section-next') {
        $target = $that.closest('section').next();
      }
      // Scroll to target
      if ($target.length == 1) {
        $(window).scroll();
        $('html,body').animate({
          scrollTop: $target.offset().top
        }, 500);
      } else {
        document.location.href = SITEURL + '/' + $that.attr('href');
      }
    });
  }fsyAnchorScroll();

  var Nav = function () {
    function Nav() {
      _classCallCheck(this, Nav);

      this.watch();
      this.$nav = $('.nav-main');
      this.top = 0;
    }

    _createClass(Nav, [{
      key: 'watch',
      value: function watch() {
        var nav = this;
        $(window).scroll(function () {
          var st = $(window).scrollTop();
          if (st >= 500) {
            nav.$nav.addClass('is--scrolling');
            if (st >= 1000) {
              nav.$nav.addClass('is--active');
            } else {
              nav.$nav.removeClass('is--active');
            }
          } else {
            nav.$nav.removeClass('is--scrolling');
          }
        });
      }
    }]);

    return Nav;
  }();

  var nav = new Nav();

  // $(window).scroll(function() {
  //   var st = $(window).scrollTop();
  //   if (st > 0) {
  //     $('.hero-primary').addClass('hero--is-hidden');
  //   } else {
  //     $('.hero-primary').removeClass('hero--is-hidden');
  //   }
  // });
}); // End jQuery