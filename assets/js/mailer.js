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

}); // End jQuery
