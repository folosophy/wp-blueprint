<?php

$nav_script = new Blueprint\EnqueueScript('bp_nav_script','assets/js/nav.js',BP);


// Excerpt Word Count
function excerpt_count_js(){
  /*
  $length = $bpconfig->getExcerptLength();
      echo '<script>jQuery(document).ready(function(){
jQuery('#postexcerpt .handlediv').after('<div style=\'position:absolute;top:12px;right:34px;color:#666;\'><small>Excerpt length: </small><span id=\'excerpt_counter\'></span><span style=\'font-weight:bold; padding-left:7px;\'>/ 120</span><small><span style=\'font-weight:bold; padding-left:7px;\'>character(s).</span></small></div>');
     jQuery('span#excerpt_counter').text(jQuery('#excerpt').val().length);
     jQuery('#excerpt').keyup( function() {
         if(jQuery(this).val().length > 120){
            jQuery(this).val(jQuery(this).val().substr(0, 120));
        }
     jQuery('span#excerpt_counter').text(jQuery('#excerpt').val().length);
   });
});</script>';
*/
}
//add_action( 'admin_head-post.php', 'excerpt_count_js');
//add_action( 'admin_head-post-new.php', 'excerpt_count_js');

add_post_type_support('page','excerpt');

// Icon Field

function bp_add_field_icon($field) {
  $field['choices'] = array('none'=>'None');
  $files = glob(get_template_directory() . '/assets/img/icon-*.svg');
  foreach ($files as $file) {
    $key   = basename($file,'.svg');
    $value = str_replace('icon-','',$key);
    $value = str_replace('-',' ',$value);
    $value = ucwords($value);
    $field['choices'][$key] = $value;
  }
  return $field;
} add_filter('acf/load_field/key=field_59847a1f77943','bp_add_field_icon');

bp_glob_require('inc/core*');

// TODO: Idk
function add_cta_menu_cta_button($items,$args) {
    $items .= "
      <li class='menu-main__item'>
        <a href='#section-contact'>
          <div class='menu-main__item__title menu-main__button-text'>
            Connect
          </div>
          <div class='menu-main__button'>Connect</div>
        </a>
      </li>
    ";
    return $items;
} add_filter( 'wp_nav_menu_items','add_cta_menu_cta_button', 10, 2 );

// TODO: Move to normalize, better solution for Discussion Meta Box
function bp_acf_admin_style() {
  echo "
    <style>
      .acf-editor-wrap iframe {
        height: 150px !important;
        min-height: 0 !important;
      }
      .wp-media-buttons .insert-media {display:none;}
      .nolabel .acf-label, .hide {display:none;}
      #commentstatusdiv {display:none;}
      .acf-field-group {padding:0 !important;}
      .acf-field-group > .acf-label {display:none !important;}
      .acf-field-group .acf-fields {border:none !important;}
      .acf-field-group .acf-field-group > .acf-input {padding:0 !important;}
      .acf-field-group > .acf-input {padding-left: 0 !important;}
      .acf-field-group {border-top: 2px solid rgba(0,0,0,.1) !important;}
    </style>
  ";
} add_action('admin_head','bp_acf_admin_style');

// TODO: Require acf load files and move to own file
function bp_acf_load_showcase_icons( $field ) {
    $field['choices'] = array();
    $files = bp_glob_require('assets/img/icon-',BP);
    if ($files) {
      foreach ($files as $file) {
        $key  = basename($file);
        $val  = basename($file,'.svg');
        $val  = ucwords(str_replace('icon-','',$val));
        $field['choices'][$key] = $val;
      }
    } else {
      $field = null;
    }
    return $field;
} add_filter('acf/load_field/name=icon', 'bp_acf_load_showcase_icons');

// TODO: move to proper folder/file, rename function
function my_acf_json_load_point( $paths ) {
    // append path
    $path = BP_PATH . '/acf-json';
    array_push($paths,$path);
    // return
    return $paths;

} add_filter('acf/settings/load_json', 'my_acf_json_load_point');

add_theme_support('menus');

function register_theme_menus() {
	register_nav_menus(
		array(
			'main' => 'Main',

		)
	);
}

add_action('init','register_theme_menus');

new Blueprint\Script\GoogleFonts('https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900');


add_theme_support( 'post-thumbnails' );

function bp_head_scripts() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('bp_mailer_script',BP_REL_PATH . '/assets/js/mailer.js');
  wp_enqueue_script('slider',BP_REL_PATH . '/assets/js/slider.js');
} add_action('wp_enqueue_scripts','bp_head_scripts');

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

// Dump into full screen dev window

function dump_dev($stuff) {
  ob_start();
  var_dump($stuff);
  $stuff = ob_get_clean();
  echo var_dump("
    <div class='dev-dump' style='position:fixed; background:white; z-index:999999999999999999999999999; width:100%; height: 100%; padding:100px;'>
      <pre>$stuff</pre>
    </div>
  ");
}

function diedump($stuff) {
  echo "<pre>";
  wp_die(var_dump($stuff));
  echo "</pre>";
}

// TODO: Deregister 'post' (function or part of class?) MTF

function custom_unregister_theme_post_types() {
    global $wp_post_types;
    if (isset($wp_post_types['post'])) {
      unset($wp_post_types['post']);
    }
  }
//add_action( 'init', 'custom_unregister_theme_post_types', 20 );



function admin_field_inspector() {
  if (current_user_can('administrator')) {
    $editor_script = (new Blueprint\EnqueueScript('bp_editor_shortcodes','assets/js/admin.js',BP))
    ->addAction('admin_enqueue_scripts');
  } else {wp_die();}
} add_action('admin_head','admin_field_inspector');


add_action('acf/render_field',function($field) {
  if (current_user_can('administrator')) {
    //echo $field['key'];
  }
  return $field;
});
