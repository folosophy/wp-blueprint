jQuery(document).ready(function($){

class EditorShortcodes {

  constructor() {
    this.watchAddContent();
    this.watchSelectShortcode();
    this.watchCreate();
    this.watchSelectImage();
  }

  watchAddContent() {
    $('.bp-add-content').click(function(e) {
      $('body').addClass('bp-modal--active');
    });
  }

  watchSelectShortcode() {
    var $shortcode = $('.bp-editor-shortcodes .bp-shortcode'),
        parent = this;
    $shortcode.click(function() {
      var $that = $(this),
          type  = $that.attr('type');
      $.post({
        url: ajaxurl,
        data: {
          'action' : 'bp_editor_options',
          'type'   : type
        },
        success: function(r) {
          $('.bp-editor-shortcodes .bp-shortcode-options').html(r);
          $('.bp-editor-shortcodes .bp-shortcodes').hide();
          parent.watchCreate();
        },
        error: function(r) {
          console.log(r);
        }
      });
    });
  }

  watchCreate() {
    var $create = $('.create-editor-shortcode');
    $create.click(function(e) {
      e.preventDefault();
      var $that = $(this),
          $form = $that.closest('form'),
          $fields = $form.find('.field'),
          args = '',
          shortcode = '',
          type = $form.attr('shortcode-type');
      $fields.each(function(i) {
        var $that = $(this),
            val = $that.val(),
            arg = $that.attr('name') + '="' + $that.val() + '"';
        if (!val) {
          alert('Please complete all fields.');
          return false;
        }
        args += arg + ' ';
        if (i == $fields.length - 1) {
          shortcode = `[bp-${type} ${args}]`;
          console.log(shortcode);
          tinyMCE.activeEditor.execCommand('mceInsertContent',false,shortcode);
          $('body').removeClass('bp-modal--active');
          $('.bp-editor-shortcodes .bp-shortcode-options').html('');
          $('.bp-editor-shortcodes .bp-shortcodes').css('display','');
        }
      });
    });
  }

  watchSelectImage() {
    $('body').on('click','.bp-image--select',this.getMedia);
  }

  getMedia() {
    $('.bp-modal').hide();
    var image = wp.media({
        title: 'Upload Image',
        multiple: false
    }).open()
    .on('select', function(e){
        var selected = image.state().get('selection').first().toJSON(),
            id = selected.id,
            thumb = selected.sizes.thumbnail.url;
        console.log(selected);
        $('form.bp-shortcode-options').find('input').val(id);
        $('form.bp-shortcode-options').find('img').attr('src',thumb);
      $('.bp-modal').css('display','');
    });
  }

}

var editorShortcodes = new EditorShortcodes();

// TODO: MTF;

var content = '<span class="dashicons dashicons-media-code"></span>';
$('.ab-top-menu').append("<li style='padding: 0 20px' id='bp-adminbar-ticker'><b id='bp-adminbar-ticker' class='ab-item' style='color:white;'></b></li>");
$('.acf-field').hover(function() {
  var name = '### ' + $(this).attr('data-key') + ' ###';
  $('#bp-adminbar-ticker').text(name);
});

});
