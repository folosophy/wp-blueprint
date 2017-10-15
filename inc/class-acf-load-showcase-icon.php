<?php

function bp_acf_load_showcase_icons( $field ) {
    $field['choices'] = array('test'=>'Test');
    return $field;
} add_filter('acf/load_field/name=icon', 'bp_acf_load_showcase_icons');
