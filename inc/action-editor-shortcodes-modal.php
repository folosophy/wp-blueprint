<?php

function bp_add_shortcode_modal() {
  $types = array('image');
  $shortcodes = '';
  foreach ($types as $type) {
    $shortcodes .= "
      <div class='bp-shortcodes'>
        <h3>Shortcodes</h3>
        <button class='bp-shortcode button' type='$type'>Image</button>
      </div>
    ";
  }
  echo "
    <div class='bp-modal bp-editor-shortcodes'>
      $shortcodes
      <div class='bp-shortcode-options'></div>
    </div>
  ";
} add_action('admin_footer','bp_add_shortcode_modal');
