'use strict';

jQuery(document).ready(function ($) {

  $('#acf-field_template').live('change', function () {

    var $that = $(this),
        data = {
      field: 'template',
      val: $that.val(),
      id: 445,
      action: 'bp_update_field'
    };

    $.post(ajax.url, data, function (r) {
      console.log(r);
    });

    acf.ajax.update('template', $(this).val()).fetch();
    $(document).trigger('acf/update_field_groups');
  });
}); // End jQuery