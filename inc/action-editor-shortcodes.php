<?php

function bp_get_editor_shortcodes() {
  $data  = $_REQUEST;
  $name  = $data['name'];
  $class = 'Blueprint\\Shortcode\\' . $name;
  $shortcode = new $class();
  $shortcode->render(); 
} add_action('wp_ajax_bp_get_editor_shortcodes','bp_get_editor_shortcodes');
