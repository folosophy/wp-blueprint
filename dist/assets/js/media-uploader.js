'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

jQuery(document).ready(function ($) {
  var EditorShortcodes = function () {
    function EditorShortcodes() {
      _classCallCheck(this, EditorShortcodes);

      this.watchAddContent();
      this.watchSelectShortcode();
      this.watchCreate();
      this.watchSelectImage();
    }

    _createClass(EditorShortcodes, [{
      key: 'watchAddContent',
      value: function watchAddContent() {
        $('.bp-add-content').click(function (e) {
          $('body').addClass('bp-modal--active');
        });
      }
    }, {
      key: 'watchSelectShortcode',
      value: function watchSelectShortcode() {
        var $shortcode = $('.bp-editor-shortcodes .bp-shortcode'),
            parent = this;
        $shortcode.click(function () {
          var $that = $(this),
              type = $that.attr('type');
          $.post({
            url: ajaxurl,
            data: {
              'action': 'bp_editor_options',
              'type': type
            },
            success: function success(r) {
              $('.bp-editor-shortcodes .bp-shortcode-options').html(r);
              $('.bp-editor-shortcodes .bp-shortcodes').hide();
              parent.watchCreate();
            },
            error: function error(r) {
              console.log(r);
            }
          });
        });
      }
    }, {
      key: 'watchCreate',
      value: function watchCreate() {
        var $create = $('.create-editor-shortcode');
        $create.click(function (e) {
          e.preventDefault();
          var $that = $(this),
              $form = $that.closest('form'),
              $fields = $form.find('.field'),
              args = '',
              shortcode = '',
              type = $form.attr('shortcode-type');
          $fields.each(function (i) {
            var $that = $(this),
                val = $that.val(),
                arg = $that.attr('name') + '="' + $that.val() + '"';
            if (!val) {
              alert('Please complete all fields.');
              return false;
            }
            args += arg + ' ';
            if (i == $fields.length - 1) {
              shortcode = '[bp-' + type + ' ' + args + ']';
              console.log(shortcode);
              tinyMCE.activeEditor.execCommand('mceInsertContent', false, shortcode);
              $('body').removeClass('bp-modal--active');
              $('.bp-editor-shortcodes .bp-shortcode-options').html('');
              $('.bp-editor-shortcodes .bp-shortcodes').css('display', '');
            }
          });
        });
      }
    }, {
      key: 'watchSelectImage',
      value: function watchSelectImage() {
        $('body').on('click', '.bp-image--select', this.getMedia);
      }
    }, {
      key: 'getMedia',
      value: function getMedia() {
        $('.bp-modal').hide();
        var image = wp.media({
          title: 'Upload Image',
          multiple: false
        }).open().on('select', function (e) {
          var selected = image.state().get('selection').first().toJSON(),
              id = selected.id,
              thumb = selected.sizes.thumbnail.url;
          console.log(selected);
          $('form.bp-shortcode-options').find('input').val(id);
          $('form.bp-shortcode-options').find('img').attr('src', thumb);
          $('.bp-modal').css('display', '');
        });
      }
    }]);

    return EditorShortcodes;
  }();

  var editorShortcodes = new EditorShortcodes();

  // TODO: MTF;

  var content = '<span class="dashicons dashicons-media-code"></span>';
  $('.ab-top-menu').append("<li style='padding: 0 20px' id='bp-adminbar-ticker'><b id='bp-adminbar-ticker' class='ab-item' style='color:white;'></b></li>");
  $('.acf-field').hover(function () {
    var name = '### ' + $(this).attr('data-key') + ' ###';
    $('#bp-adminbar-ticker').text(name);
  });
});