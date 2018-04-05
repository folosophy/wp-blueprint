'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

jQuery(document).ready(function ($) {
  var ContactForm = function () {
    function ContactForm() {
      _classCallCheck(this, ContactForm);

      this.$form = $('.form-contact,#form-contact');
      this.watchForms();
      this.watchUi();
    }

    _createClass(ContactForm, [{
      key: 'checkLogic',
      value: function checkLogic($form, val) {
        var $logic = $form.find('.has-logic');
        $logic.each(function () {
          var $field = $(this);
          if ($field.attr('logic-value') == val) {
            $field.removeClass('hidden_by_logic');
            $field.find('.element').removeAttr('disabled');
          } else {
            $field.addClass('hidden_by_logic');
            $field.find('.element').attr('disabled', '');
          }
        });
      }
    }, {
      key: 'watchForms',
      value: function watchForms() {

        var self = this;

        $('body').on('click', 'form .button-submit', function (e) {
          e.preventDefault();
          $(this).closest('form').submit();
        });

        $('form').find('select').on('change', function () {
          var $field = $(this),
              $form = $(this).closest('form'),
              val = $field.val();
          self.checkLogic($form, val);
        });

        this.$form.submit(function (e) {
          e.preventDefault();
          var $form = $(this);
          self.validateFields($form);
        });
      }
    }, {
      key: 'validateFields',
      value: function validateFields($form) {

        var $fields = $form.find('.field'),
            self = this,
            fields = {};

        $fields.each(function (i, el) {

          var $field = $(this),
              $el = $field.find('.element');

          if ($el.attr('required') && $el.is(':not(:disabled)') && !$el.val()) {

            self.setFieldError($field);
            return false;
          } else {

            var name = $el.attr('name');

            $el.removeClass('error');

            fields[name] = $el.val();

            if (i == $fields.length - 1) {
              self.submitForm($form, fields);
            }
          }
        });
      }
    }, {
      key: 'setFieldError',
      value: function setFieldError($field) {
        window.scroll({
          top: $field.offset().top - 150,
          behavior: 'smooth'
        });
        setTimeout(function () {
          $field.addClass('error');
        }, 200);
      }
    }, {
      key: 'submitForm',
      value: function submitForm($form, fields) {

        var data = {
          'action': 'bp_contact_form',
          'fields': fields,
          'form': {
            'name': $form.attr('name')
          }
        };

        var $submit = $form.find('.button-submit'),
            submitText = $submit.text();

        $submit.text('Sending...');

        $.post(ajax.url, data, function (r) {
          console.log(r);
          r = JSON.parse(r);
          setTimeout(function () {
            $submit.text(r.message);
            setTimeout(function () {
              $submit.text(submitText);
              $form[0].reset();
              $form.find('.element').trigger('change');
            }, 2000);
          }, 1000);
        });
      }
    }, {
      key: 'watchUi',
      value: function watchUi() {
        $('body').on('change', 'input,textarea', function () {
          var $input = $(this),
              $field = $input.closest('.field'),
              $label = $input.find('label');
          if ($input.val()) {
            $input.removeClass('is-empty');
            $field.addClass('has-value');
          } else {
            $input.addClass('is-empty');
            $field.removeClass('has-value');
          }
          return;
        });
      }
    }]);

    return ContactForm;
  }();

  var contact = new ContactForm();
}); // End jQuery