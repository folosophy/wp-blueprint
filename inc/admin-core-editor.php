<?php

if (bp_is_local()) {

  function bp_editor_scripts() {
    wp_enqueue_script('bp_editor_script',BP_REL_PATH . '/assets/js/admin-editor.js');
  } add_action('admin_enqueue_scripts','bp_editor_scripts');
  //
  // add_action('media_buttons',function() {
  //   echo "<button id='bp-add-media' class='button'>BP Add Media</button>";
  // });

}
