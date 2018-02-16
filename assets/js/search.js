'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

jQuery(document).ready(function ($) {
  var BlueprintSearch = function () {
    function BlueprintSearch() {
      _classCallCheck(this, BlueprintSearch);

      this.watchSiteSearch();
    }

    _createClass(BlueprintSearch, [{
      key: 'watchSiteSearch',
      value: function watchSiteSearch() {

        var self = this,
            open = false,
            $search = $('#site-search'),
            $searchInput = $search.find('#site-search__input');

        $(document).on('keydown.openSearch', function (e) {

          var $target = e.target.tagName.toLowerCase();

          if ($target == 'body' && e.keyCode >= 48 && e.keyCode <= 90) {
            $('#site-search').addClass('is__searching');
            $('#site-search__input').focus();
          }

          $(document).on('keydown.exitSiteSearch', function (e) {
            self.exitSiteSearch(e);
          });
        });

        var $searchForm = $searchInput.closest('form'),
            searchString;

        $searchInput.on('keyup', function () {
          var obj = {
            's': $searchInput.val()
          },
              query = $.param(obj);
          searchString = '?' + query;
        });
      }
    }, {
      key: 'exitSiteSearch',
      value: function exitSiteSearch(e) {
        if (e.keyCode == 27) {
          $('#site-search').removeClass('is__searching');
          $('#site-search__input').val('');
          $(document).unbind('keyup.closeSiteSearch');
        }
      }
    }]);

    return BlueprintSearch;
  }();

  var search = new BlueprintSearch();

  $('.form-site-search').submit(function (e) {
    e.preventDefault();
    var search = $(this).find('input[type="search"]').val();
    location = 'http://localhost/liveandrebel.com/?s=' + search;
  });

  var SearchPage = function () {
    function SearchPage() {
      _classCallCheck(this, SearchPage);

      this.watchButton();
      this.offset = 0;
      this.$loadMore = $('.load-more');
      this.$results = $('#search-results .grid');
    }

    _createClass(SearchPage, [{
      key: 'watchButton',
      value: function watchButton() {
        // var self = this;
        // $('a.load-more-posts').click(function(e) {
        //   e.preventDefault();
        //   self.offset = self.$results.children().length + self.offset;
        //   var query = {
        //     'offset': self.offset
        //   };
        //   var data = {
        //     'action': 'bp_get_posts',
        //     'query': query
        //   };
        //   $.post(ajax.url, data, function(r) {
        // 		self.$results.append(r);
        //     console.log(r);
        // 	});
        // });
      }
    }]);

    return SearchPage;
  }();

  var searchPage = new SearchPage();
}); // End jQuery