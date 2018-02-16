'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

jQuery(document).ready(function ($) {
  var ContactForm = function () {
    function ContactForm() {
      _classCallCheck(this, ContactForm);

      this.$form = $('.form-contact');
      this.watchForms();
    }

    _createClass(ContactForm, [{
      key: 'watchForms',
      value: function watchForms() {
        this.$form.submit(function (e) {
          e.preventDefault();
          var $form = $(this),
              $submit = $form.find('.form__submit'),
              submitText = $submit.text(),
              data = {
            'action': 'bp_contact_form',
            'form': $form.serialize()
          };
          console.log($submit.length);
          $submit.text('Sending...');
          $.post(ajax.url, data, function (r) {
            setTimeout(function () {
              $submit.text('Message sent!');
              setTimeout(function () {
                $submit.text(submitText);
              }, 3000);
            }, 1000);
          });
        });
      }
    }]);

    return ContactForm;
  }();

  var contact = new ContactForm();
}); // End jQuery