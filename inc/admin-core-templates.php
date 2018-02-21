<?php

add_action('acf/prepare_field/key=field_template_is_locked',function($field) {
  if (current_user_can('administrator')) {return $field;}
  else {return false;}
});

add_action('acf/load_field/key=field_template',function($field) {

  // Check if template is locked
  $locked = get_post_meta(get_the_ID(),'template_is_locked',true);
  $admin = current_user_can('administrator');

  // Lock template if locked and user is not admin
  if ($locked && !$admin) {
    $val = get_post_meta(get_the_ID(),'template',true);
    $field['choices'] = array($val => ucwords($val));
    $field['wrapper']['class'] .= ' nolabel ';
  }

  if (!$locked || $admin) {

    $field['choices'] = array();

    $base = get_template_directory() . '/parts/';
    $files = glob($base . get_post_type() . '*.php');

    foreach ($files as $file) {
      $key = str_replace($base,'',$file);
      $key = str_replace('.php','',$key);
      $val = str_replace('page-','',$key);
      $val = str_replace('_',' ',$val);
      $val = ucwords(str_replace('-',' ',$val));
      $field['choices'][$key] = $val;
    }

  }

  return $field;

});

// Page Template Location Rule

add_filter('acf/location/rule_types', 'acf_location_rules_types');

function acf_location_rules_types( $choices ) {

    $choices['template'] = 'Template';

    return $choices;

}

add_filter('acf/location/rule_match/template', 'acf_location_rules_match_user', 10, 3);
function acf_location_rules_match_user( $match, $rule, $options ) {

  if (get_field('template') == $rule['value']) {$match = true;}

  return $match;

}

if (is_admin()) {

  $acf_script = (new Blueprint\enqueue\Script('bp_acf_script','acf.js',BP))
    ->addAjax()
    ->setAction('admin_enqueue_scripts');

  function bp_update_field() {
    $data = $_POST;
    $update = update_field($data['field'],$data['value'],$data['id']);
    wp_die();
  } add_action( 'wp_ajax_bp_update_field', 'bp_update_field' );

}
