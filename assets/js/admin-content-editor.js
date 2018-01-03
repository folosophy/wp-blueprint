jQuery(document).ready(function($) {

class ContentEditor {

  constructor() {
    this.$switchVisual = $('#content-tmce');
    this.$switchText   = $('#content-html');
    this.watchSwitch();

  }

  watchSwitch() {
    this.$switchVisual.click(function() {
      alert('test');
    });
  }

}

var editor = new ContentEditor();

}); // End jQuery
