jQuery(document).ready(function($) {

  function fyTempMailer() {
    $('.form-contact').submit(function(e) {
      e.preventDefault();
      var $form = $(this),
          email   = $form.find('input[name="Email"]').val(),
          name    = $form.find('input[name="Name"]').val(),
          body    = $form.find('textarea[name="Message"]').val(),
          subject = 'Folosophy Website Message From ' + name,
          to      = 'andrew@folosophy.com';
      if ($form.attr('send-method') == 'manual') {
        document.location = "mailto:"+to+"?subject="+subject+"&body="+body;
      }
    });
  } fyTempMailer();

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
