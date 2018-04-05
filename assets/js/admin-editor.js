jQuery(document).ready(function($) {

$('body').on('click','.wp-editor-wrap img',function(e) {

  e.preventDefault();
  alert('test');

});

}); // End jQuery
