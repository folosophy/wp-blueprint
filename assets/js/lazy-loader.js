// Version 2.0

jQuery(document).ready(function($) {

// Initialize Presto
function psInit() {
 psLoadImages();
}

// Main Class
class Presto {

  constructor() {
    this.isLoading  = false;
    this.needsCheck = true;
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
    if (this.isLoading == true) {
      this.needsCheck = true;
      return false;
    }
    this.isLoading  = true;
    this.needsCheck = false;
    // Vars
    var self      = this,
        presto    = this,
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
      if (self.inViewport($that,1000)) {
        var srcset = $that.attr('data-srcset');
        if (srcset) {
          $that.removeClass('ps-unloaded');
          $that.addClass('ps-loaded');
          $that.attr('srcset',$that.attr('data-srcset'));
        }
      }
      // Set loading timeout
      if (i == $unloaded.length - 1) {
        setTimeout(function() {
          self.isLoading = false;
          if (self.needsCheck) {
            console.log('end load, needs loading');
            self.loadImages();
          }
        },20);
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
        delay += 100;
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
    if (typeof archive !== 'undefined') {
      this.watchLoadMore();
    }
  }

  watchLoadMore() {
    var self = this;
    self.$loadMore.click(function(e) {
      var $loadMore      = $(this),
          $gridContainer = $loadMore.closest('.grid-container'),
          $grid          = $gridContainer.find('.grid-post');
      e.preventDefault();
      var data = {
        'action'     : 'bp_ajax_load_posts',
        'query_vars' : archive.query_vars
      };
      $loadMore.text('Loading...');
      $.ajax({
        method: 'POST',
        url: ajax.url,
        data : data,
        dataType: 'json',
        success: function(r) {
          if (r.posts) {
            archive.query_vars = r.query_vars;
            $grid.append(r.posts);
            if (r.next == false) {$loadMore.remove();}
            else {$loadMore.text($loadMore.attr('data-label'));}
            setTimeout(function() {
              $(window).scroll();
            },100);
          } else {
            self.$loadMore.text('No posts found.');
            setTimeout(function() {
              self.$loadMore.remove();
            },1500);
          }
        }
      });
    });
  }

}

var ajaxLoadPosts = new AjaxLoadPosts();

}); // End jQuery
