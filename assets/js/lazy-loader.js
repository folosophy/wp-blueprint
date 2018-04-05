// Version 2.0

jQuery(document).ready(function($) {

class LazyLoader {

  constructor() {

    // $('body').append("<div id='debug'></div>");
    // this.$debug = $('#debug');
    // this.$debug.css({
    //   bottom: 0,
    //   right: 0,
    //   background: 'white',
    //   minWidth: '300px',
    //   minHeight: '300px',
    //   position: 'fixed',
    //   border: '2px solid black'
    // });

    this.isLoading  = false;
    this.needsCheck = true;
    this.check();
    this.watchModules();

  }

  inView($el,range=0) {

    var sT    = $(window).scrollTop() - range,
        sB    = $(window).scrollTop() + $(window).height() + range,
        elH   = $el.height(),
        elT   = $el.offset().top,
        elB   = $el.offset().top + elH;

    if ((elT >= sT && elT <= sB) || (elB >= sT && elB <= sB) || (elT <= sT && elB >= sB)) {
      return true;
    } else {
      return false;
    }

  }

  check() {

    var self = this,
        $sections = $('section,header');

    // if (self.isLoading) {
    //   self.needsLoading = true;
    //   return false;
    // } else {self.isLoading = true;}

    $sections.each(function(i,el) {

      var $section = $(this);

      if (self.inView($section)) {
        self.loadItems($section);
      } else {
      }

      // if (i == $sections.length - 1) {
      //   self.isLoading = false;
      //   if (self.needsCheck == true) {
      //     self.check();
      //   }
      //   self.needsCheck = false;
      // }

    });

  }

  watchModules() {

    var self = this;

    $(window).scroll(function() {

      self.check();

    });

  }

  loadItems($section) {

    var self = this,
        $items = $section.find('.lazy-item.lazy-unloaded'),
        delay  = 0;

    $items.each(function() {

      var $item  = $(this),
          inView = self.inView($item);

      if (self.inView($item,1000)) {

        if ($item.hasClass('lazy-media') && !$item.hasClass('lazy-preloaded')) {
          $item.attr('src',$item.attr('data-src'));
          $item.attr('srcset',$item.attr('data-srcset'));
          $item.addClass('lazy-preloaded');
        }

        if (self.inView($item)) {
          setTimeout(function() {
            $item.removeClass('lazy-unloaded');
            $item.addClass('lazy-loaded');
          },delay);
          delay += 50;
        }

      }

    });

  }

  loadImages($section) {

    var $images = $section.find('img.lazy-item');

    $images.each(function() {
      var $img = $(this);
      $img.attr('srcset',$img.attr('data-srcset'));
    });

  }

}

var ll = (new LazyLoader());



// Ajax Load Posts

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
          $grid          = $gridContainer.find('.grid');
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
            self.$loadMore.text('End of results.');
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

class Video {

  constructor() {
    this.play = '.video__play_button';
    this.watch();
  }

  watch() {

    $('body').on('click','.video__play_button',function() {
      var $container = $(this).closest('.container-video'),
          $img       = $container.find('.video__thumbnail'),
          $play      = $container.find('.video__play_button'),
          $video     = $container.find('.video');
      $container.addClass('is-loading');
      $video.attr('src',$video.attr('data-src'));
      setTimeout(function() {
        $img.remove();
      },500);
    });

  }

}

var video = (new Video());

}); // End jQuery
