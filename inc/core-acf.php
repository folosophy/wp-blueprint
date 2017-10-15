<?php

function bp_get_field_group($group_name,$id=null) {
  if (!$id) {$id = get_the_ID();}
  global $wpdb;
  $group_name = esc_sql($group_name);
  $results = $wpdb->get_results(
    "SELECT * FROM wp_postmeta WHERE post_id = $id AND meta_key LIKE 'featured_media'"
  );
  $fields = array();
  foreach($results as $field) {

  }
}
