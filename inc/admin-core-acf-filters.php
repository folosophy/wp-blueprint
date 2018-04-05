<?php

function my_acf_load_value( $value, $post_id){
    if (!$value) {$value = get_post_thumbnail_id($post_id) ?? null;}
    return $value;
}

// acf/load_value/key={$field_key} - filter for a specific field based on it's name
add_filter('acf/load_value/key=field_featured_image','my_acf_load_value',10,2);
