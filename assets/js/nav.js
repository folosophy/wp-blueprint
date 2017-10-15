jQuery(document).ready(function($) {

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
  $ham.click(function() {
    $body.toggleClass(mbOpen);
  });
  $exit.on('click touchstart', function() {
    $body.removeClass(mbOpen);
  });
  $navAnchor.click(function() {
    $body.removeClass(mbOpen);
  });
  // Hide/show main nav on scroll
  $(document).scroll(function() {
    var st = $body.scrollTop();
    if (st < 300) {$body.addClass(nmvHid);}
    ls = st;
  });

} fsyMobileNav();

function fsyAnchorScroll() {
  var $anchor = $('a[href^="#"]');
  $anchor.on('click touchstart', function(e) {
    e.preventDefault();
    var $that = $(this),
        $target = $($that.attr('href'));
    // Scroll to target
    if ($target.length == 1) {
      console.log($target);
      $('html,body').animate({
        scrollTop: $target.offset().top
      },500);
    } else {
      document.location.href = WPURLS.siteurl + '/' + $that.attr('href');
    }
  });
} fsyAnchorScroll();

class Nav {

  constructor () {
    this.watch();
    this.$nav = $('.nav-main');
    this.top = 0;
  }

  watch() {
    var nav = this;
    $(window).scroll(function() {
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

}

var nav = new Nav();

}); // End jQuery