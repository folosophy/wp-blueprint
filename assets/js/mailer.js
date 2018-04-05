jQuery(document).ready(function($) {

class ContactForm {

  constructor() {
    this.$form = $('.form-contact,#form-contact');
    this.watchForms();
    this.watchUi();
  }

  checkLogic($form,val) {
    var $logic = $form.find('.has-logic');
    $logic.each(function() {
      var $field = $(this);
      if ($field.attr('logic-value') == val) {
        $field.removeClass('hidden_by_logic');
        $field.find('.element').removeAttr('disabled');
      } else {
        $field.addClass('hidden_by_logic');
        $field.find('.element').attr('disabled','');
      }
    });
  }

  watchForms() {

    var self = this;

    $('body').on('click','form .button-submit',function(e) {
      e.preventDefault();
      $(this).closest('form').submit();
    });

    $('form').find('select').on('change',function() {
      var $field = $(this),
          $form  = $(this).closest('form'),
          val    = $field.val();
      self.checkLogic($form,val);
    });

    this.$form.submit(function(e) {
      e.preventDefault();
      var $form = $(this);
      self.validateFields($form);
    });

  }

  validateFields($form) {

    var $fields = $form.find('.field'),
        self    = this,
        fields  = {};

    $fields.each(function(i,el) {

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
          self.submitForm($form,fields);
        }
      }

    });

  }

  setFieldError($field) {
    window.scroll({
      top: $field.offset().top - 150,
      behavior: 'smooth'
    });
    setTimeout(function() {
      $field.addClass('error');
    },200);
  }

  submitForm($form,fields) {

    var data = {
      'action': 'bp_contact_form',
      'fields'  : fields,
      'form' : {
        'name' : $form.attr('name')
      }
    };

    var $submit = $form.find('.button-submit'),
        submitText = $submit.text();

    $submit.text('Sending...');

    $.post(ajax.url,data,function(r) {
      console.log(r);
      r = JSON.parse(r);
      setTimeout(function() {
        $submit.text(r.message);
        setTimeout(function() {
          $submit.text(submitText);
          $form[0].reset();
          $form.find('.element').trigger('change');
        },2000);
      },1000);
    });

  }

  watchUi() {
    $('body').on('change','input,textarea',function() {
      var $input = $(this),
          $field = $input.closest('.field'),
          $label = $input.find('label');
      if ($input.val()) {
        $input.removeClass('is-empty');
        $field.addClass('has-value');
      }
      else {
        $input.addClass('is-empty');
        $field.removeClass('has-value');
      }
      return;
    });
  }

}

var contact = new ContactForm();

}); // End jQuery
