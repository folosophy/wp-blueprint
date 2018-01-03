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

class AjaxLoadPosts {

  constructor() {
    this.$loadMore = $('.load-more-posts');
    this.watchLoadMore();
  }

  watchLoadMore() {
    var self = this;
    self.$loadMore.click(function(e) {
      var $loadMore      = $(this),
          $gridContainer = $loadMore.closest('.grid-container'),
          $grid          = $gridContainer.find('.post-grid');
      e.preventDefault();
      var data = {
        'action'     : 'bp_ajax_load_posts',
        'query_vars' : archive.query_vars
      };
      $loadMore.text('Loading...');
      $.post(
        ajax.url,
        data
      ).success(function(r) {
        r = JSON.parse(r);
        console.log(r);
        archive.query_vars = r.query_vars;
        $grid.append(r.posts);
        if (r.next == false) {$loadMore.remove();}
        else {$loadMore.text($loadMore.attr('data-label'));}
        $(window).scroll();
      });
    });
  }

}

var ajaxLoadPosts = new AjaxLoadPosts();

}); // End jQuery
