// Version 2.0

jQuery(document).ready(function($) {

// Initialize Presto
function psInit() {
 psLoadImages();
}

// Main Class
class Presto {

  constructor() {
    this.isLoading = false;
    this.checkImages();
  }

  checkImages() {
    var that = this;
    this.loadImages();
    $(window).on('scroll',function() {
      that.loadImages();
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

}

var presto = new Presto();


}); // End jQuery
