'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Version 2.0

jQuery(document).ready(function ($) {

  // Initialize Presto
  function psInit() {
    psLoadImages();
  }

  // Main Class

  var Presto = function () {
    function Presto() {
      _classCallCheck(this, Presto);

      this.isLoading = false;
      this.needsCheck = true;
      $('p:not(.lazy-loaded)').addClass('lazy-unloaded');
      this.checkImages();
      this.checkSections();
    }

    _createClass(Presto, [{
      key: 'checkImages',
      value: function checkImages() {
        var that = this;
        this.loadImages();
        $(window).on('scroll', function () {
          that.loadImages();
          that.checkSections();
        });
      }
    }, {
      key: 'loadImages',
      value: function loadImages() {
        // Check if loading
        if (this.isLoading == true) {
          this.needsCheck = true;
          return false;
        }
        this.isLoading = true;
        this.needsCheck = false;
        // Vars
        var self = this,
            presto = this,
            $unloaded = $('.ps-lazy.ps-unloaded'),
            range = 1000,
            sT = $(window).scrollTop() - range,
            sB = $(window).scrollTop() + $(window).height() + range;
        // Loop through unloaded images
        $unloaded.each(function (i, $el) {
          var $that = $(this),
              elH = $that.height(),
              elT = $that.offset().top,
              elB = $that.offset().top + elH;
          // Check if visible
          if (self.inViewport($that, 1000)) {
            var srcset = $that.attr('data-srcset');
            if (srcset) {
              $that.removeClass('ps-unloaded');
              $that.addClass('ps-loaded');
              $that.attr('srcset', $that.attr('data-srcset'));
            }
          }
          // Set loading timeout
          if (i == $unloaded.length - 1) {
            setTimeout(function () {
              self.isLoading = false;
              if (self.needsCheck) {
                console.log('end load, needs loading');
                self.loadImages();
              }
            }, 20);
          }
        });
      }
    }, {
      key: 'checkSections',
      value: function checkSections() {
        var self = this,
            $items = $('.lazy-unloaded,p:not(.lazy-loaded)'),
            delay = 0;
        $items.each(function () {
          var $item = $(this),
              inView = self.inViewport($item);
          if (inView) {
            setTimeout(function () {
              $item.removeClass('lazy-unloaded');
              $item.addClass('lazy-loaded');
            }, delay);
            delay += 100;
          }
        });
      }
    }, {
      key: 'inViewport',
      value: function inViewport($el) {
        var range = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

        var sT = $(window).scrollTop() - range,
            sB = $(window).scrollTop() + $(window).height() + range,
            elH = $el.height(),
            elT = $el.offset().top,
            elB = $el.offset().top + elH;
        if (elT >= sT && elT <= sB || elB >= sT && elB <= sB) {
          return true;
        } else {
          return false;
        }
      }
    }]);

    return Presto;
  }();

  var presto = new Presto();

  var AjaxLoadPosts = function () {
    function AjaxLoadPosts() {
      _classCallCheck(this, AjaxLoadPosts);

      this.$loadMore = $('.load-more-posts');
      if (typeof archive !== 'undefined') {
        this.watchLoadMore();
      }
    }

    _createClass(AjaxLoadPosts, [{
      key: 'watchLoadMore',
      value: function watchLoadMore() {
        var self = this;
        self.$loadMore.click(function (e) {
          var $loadMore = $(this),
              $gridContainer = $loadMore.closest('.grid-container'),
              $grid = $gridContainer.find('.grid-post');
          e.preventDefault();
          var data = {
            'action': 'bp_ajax_load_posts',
            'query_vars': archive.query_vars
          };
          $loadMore.text('Loading...');
          $.ajax({
            method: 'POST',
            url: ajax.url,
            data: data,
            dataType: 'json',
            success: function success(r) {
              if (r.posts) {
                archive.query_vars = r.query_vars;
                $grid.append(r.posts);
                if (r.next == false) {
                  $loadMore.remove();
                } else {
                  $loadMore.text($loadMore.attr('data-label'));
                }
                setTimeout(function () {
                  $(window).scroll();
                }, 100);
              } else {
                self.$loadMore.text('No posts found.');
                setTimeout(function () {
                  self.$loadMore.remove();
                }, 1500);
              }
            }
          });
        });
      }
    }]);

    return AjaxLoadPosts;
  }();

  var ajaxLoadPosts = new AjaxLoadPosts();
}); // End jQuery