jQuery(document).ready(function($) {

class BlueprintSearch {

  constructor() {
    this.watchSiteSearch();
  }

  watchSiteSearch() {

    var self = this,
        open = false,
        $search = $('#site-search'),
        $searchInput = $search.find('#site-search__input');

    $(document).on('keydown.openSearch',function(e) {

      let $target = e.target.tagName.toLowerCase();

      if ($target == 'body' && e.keyCode >= 48 && e.keyCode <= 90) {
        $('#site-search').addClass('is__searching');
        $('#site-search__input').focus();
      }

      $(document).on('keydown.exitSiteSearch',function(e) {
        self.exitSiteSearch(e);
      });

    });

    var $searchForm = $searchInput.closest('form'),
        searchString;

    $searchInput.on('keyup',function() {
      var obj = {
        's' : $searchInput.val()
      },
          query = $.param(obj)
          searchString = '?' + query;
    });

  }

  exitSiteSearch(e) {
    if (e.keyCode == 27) {
      $('#site-search').removeClass('is__searching');
      $('#site-search__input').val('');
      $(document).unbind('keyup.closeSiteSearch');
    }
  }

}

let search = new BlueprintSearch;



$('.form-site-search').submit(function(e) {
  e.preventDefault();
  var search = $(this).find('input[type="search"]').val();
  location = 'http://localhost/liveandrebel.com/?s=' + search;
});

class SearchPage {

  constructor() {
    this.watchButton();
    this.offset = 0;
    this.$loadMore = $('.load-more');
    this.$results   = $('#search-results .grid');
  }

  watchButton() {
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

}

let searchPage = new SearchPage();

}); // End jQuery
