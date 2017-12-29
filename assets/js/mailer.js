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

  // TODO: MTF, finish preloader
  setTimeout(function() {
    //$('.mockup-preloader').addClass('exit');
  },1500);

  function bpVideo() {

    var $body = $('body');

    $('.button-play').click(function() {
      var $button = $(this),
          $container = $button.siblings('.container-theater'),
          $iframe = $button.siblings('iframe');
      $iframe.attr('src',$iframe.attr('play-src') + '&autoplay=1');
      // TODO: Loading animation
      setTimeout(function() {
        $button.siblings('img').hide();
        $button.hide();
      },1000);
    });

    $('.theater-exit').click(function() {
      var $container = $(this).closest('.container-theater'),
          $iframe = $container.find('iframe');
      $container.removeClass('theater--on');
      $iframe.attr('src',$iframe.attr('reset-src'));
      $body.removeClass('blackout');
    });

  } bpVideo();

}); // End jQuery
