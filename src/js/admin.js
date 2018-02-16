jQuery(document).ready(function($) {

  $('#wp-toolbar').append("<li id='bp-adminbar-ticker'>Test</li>");
  $('.acf-field').hover(function() {
    var name = $(this).attr('data-name');

  });

}); // End jQuery
