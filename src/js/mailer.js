jQuery(document).ready(function($) {

class ContactForm {

  constructor() {
    this.$form = $('.form-contact');
    this.watchForms();
  }

  watchForms() {
    this.$form.submit(function(e) {
      e.preventDefault();
      var $form      = $(this),
          $submit    = $form.find('.form__submit'),
          submitText = $submit.text(),
          data       = {
            'action': 'bp_contact_form',
            'form'  : $form.serialize()
          };
      console.log($submit.length);
      $submit.text('Sending...');
      $.post(ajax.url,data,function(r) {
        setTimeout(function() {
          $submit.text('Message sent!');
          setTimeout(function() {
            $submit.text(submitText);
          },3000);
        },1000);
      });
    });
  }

}

var contact = new ContactForm();

}); // End jQuery
