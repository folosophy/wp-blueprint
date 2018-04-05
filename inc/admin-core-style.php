<?php

// TODO: Move to normalize, better solution for Discussion Meta Box
function bp_acf_admin_style() {
  echo "
    <style>

      .hide {display:none !important;}

      // .acf-editor-wrap iframe {
      //   height: 150px !important;
      //   min-height: 0 !important;
      // }
      //.wp-media-buttons .insert-media {display:none;}
      .-top > .nolabel > .acf-label {display:none;}
      #commentstatusdiv {display:none;}

      .acf-field-editor iframe {min-height:800px;}
      .acf-clone-fields {border:none !important; padding:none !important;}

      .acf-field-group.nolabel::before {display:none !important;}
      .acf-field-group.nolabel > .acf-label {display:none !important;}
      .acf-field-group.nolabel > .acf-input {width:100% !important;}
      .acf-field-group.nolabel {padding: 0 !important;}
      .acf-field-group.nolabel > .acf-input {padding: 0 !important;}
      .acf-field-group.nolabel > .acf-input > .acf-fields { border:none !important;}

      .acf-field.-left.nolabel > .acf-label {display:none !important;}
      .acf-field.-left.nolabel::before {display:none !important;}
      .acf-field.-left.nolabel {padding-left: 0 !important;}
      .acf-field.-left.nolabel > .acf-input {width:100% !important;}

      .user-admin-color-wrap,
      .user-rich-editing-wrap,
      .user-comment-shortcuts-wrap,
      .show-admin-bar.user-admin-bar-front-wrap,
      .user-url-wrap,
      .user-description-wrap {
        display: none !important;
      }

    </style>
  ";
} add_action('admin_head','bp_acf_admin_style');
