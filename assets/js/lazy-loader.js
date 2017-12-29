// Version 2.0

jQuery(document).ready(function($) {

// Initialize Presto
function psInit() {
 psLoadImages();
}

console.log(archive.query_vars);

// Main Class
class Presto {

  constructor() {
    this.isLoading = false;
    $('p:not(.lazy-loaded)').addClass('lazy-unloaded');
    this.checkImages();
    this.checkSections();
  }

  checkImages() {
    var that = this;
    this.loadImages();
    $(window).on('scroll',function() {
      that.loadImages();
      that.checkSections();
    });
  }

  loadImages() {
    // Check if loading
    if (this.isLoading == true) {return false;}
    this.isLoading = true;
    // Vars
    var presto    = this,
        $unloaded = $('.ps-lazy.ps-unloaded'),
        range     = 1000,
        sT        = $(window).scrollTop() - range,
        sB        = $(window).scrollTop() + $(window).height() + range;
    // Loop through unloaded images
    $unloaded.each(function(i,$el) {
      var $that = $(this),
          elH = $that.height(),
          elT = $that.offset().top,
          elB = $that.offset().top + elH;
      // Check if visible
      if ((elT >= sT && elT <= sB) || (elB >= sT && elB <= sB)) {
        var src = $that.attr('src-full');
        if (src) {
          $that.removeClass('ps-unloaded').attr('src',src);
          $that.addClass('ps-loaded');
          $that.attr('src',$that.attr('src-full'));
        }
      }
      // Set loading timeout
      if (i == $unloaded.length - 1) {
        setTimeout(function() {
          presto.isLoading = false;
        },500);
      }
    });
  }

  checkSections() {
    var self = this,
        $items = $('.lazy-unloaded,p:not(.lazy-loaded)'),
        delay = 0;
    $items.each(function() {
      var $item  = $(this),
          inView = self.inViewport($item);
      if (inView) {
        setTimeout(function() {
          $item.removeClass('lazy-unloaded');
          $item.addClass('lazy-loaded');
        },delay);
        delay += 150;
      }
    });
  }

  inViewport($el,range=0) {
    var sT    = $(window).scrollTop() - range,
        sB    = $(window).scrollTop() + $(window).height() + range,
        elH   = $el.height(),
        elT   = $el.offset().top,
        elB   = $el.offset().top + elH;
    if ((elT >= sT && elT <= sB) || (elB >= sT && elB <= sB)) {
      return true
    } else {
      return false;
    }
  }

}

var presto = new Presto();

}); // End jQuery
