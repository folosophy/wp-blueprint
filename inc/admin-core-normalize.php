<?php

add_theme_support('menus');

function register_theme_menus() {
	register_nav_menus(
		array(
			'main' => 'Main',

		)
	);
}

add_action('init','register_theme_menus');
add_theme_support( 'post-thumbnails' );

function rmpts() {
  remove_post_type_support('page','editor');
} add_action('init','rmpts');

//Move Yoast to bottom
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
    remove_submenu_page('options-general.php','options-discussion.php');
}

// Removes from post and pages
add_action('init', 'remove_comment_support', 100);

function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}
// Removes from admin bar
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

// Excerpt Length

function custom_excerpt_length( $length ) {
	return bp_var('excerpt_length',20);
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Excerpt more

function new_excerpt_more( $more ) {
    return " ...";
}
add_filter('excerpt_more', 'new_excerpt_more');

// Remove posts from menu

add_action('admin_menu','remove_default_post_type');

function remove_default_post_type() {
	remove_menu_page('edit.php');
}
