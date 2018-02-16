<?php

function example_plugin_function( $plugin_array ) {

    $plugin_array['example_plugin_array'] = plugins_url( 'wp-blueprint/assets/js/mce.js');

    return $plugin_array;
}


//Add the button to hook into via js
function my_plugin_button_function( $buttons ) {

    array_push( $buttons, 'my_plugin_button' );

    return $buttons;
}


//Filter above functions through relevant tinyMCE hooks.
function my_plugin_tinymce_function() {

    add_filter( 'mce_external_plugins', 'example_plugin_function' );

    //Add to end of line 3 for TinyMCE
    add_filter( 'mce_buttons_2', 'my_plugin_button_function', 20 );
}
add_action( 'admin_head', 'my_plugin_tinymce_function' );
