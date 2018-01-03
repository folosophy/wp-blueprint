<?php

use Blueprint as bp;
use Blueprint\Enqueue as enqueue;
use \Blueprint\Part as part;

$nav_script = (new enqueue\Script('bp_nav_script','nav.js',BP))
  ->addLocalize('SITEURL',get_option('siteurl'));


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

      #acf-group_post_content {
        z-index:9999999999999;
        position:fixed;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        max-width:100%;
        max-height:100%;
      }

      .acf-editor-wrap iframe {
        height: 150px !important;
        min-height: 0 !important;
      }
      //.wp-media-buttons .insert-media {display:none;}
      .-top > .nolabel > .acf-label {display:none;}
      #commentstatusdiv {display:none;}

      .acf-clone-fields {border:none !important; padding:none !important;}

      .acf-field-group.nolabel::before {display:none !important;}
      .acf-field-group.nolabel > .acf-label {display:none !important;}
      .acf-field-group.nolabel > .acf-input {width:100% !important;}
      .acf-field-group.nolabel {padding: 0 !important;}
      .acf-field-group.nolabel > .acf-input {padding: 0 !important;}
      .acf-field-group.nolabel > .acf-input > .acf-fields { border:none !important;}

      .acf-field.nolabel > .acf-label {display:none !important;}
      .acf-field.nolabel::before {display:none !important;}
      .acf-field.nolabel > .acf-input {width:100% !important;}

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


add_theme_support( 'post-thumbnails' );

function bp_head_scripts() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('bp_mailer_script',BP_REL_PATH . '/assets/js/mailer.js');
  wp_enqueue_script('slider',BP_REL_PATH . '/assets/js/slider.js');
} add_action('wp_enqueue_scripts','bp_head_scripts');

$mailer_script = (new bp\Enqueue\Script('bp_mailer_script','mailer.js',BP))
  ->addAjax();

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



// function admin_field_inspector() {
//   if (current_user_can('administrator')) {
//     $editor_script = (new Blueprint\EnqueueScript('bp_editor_shortcodes','admin.js',BP))
//     ->addAction('admin_enqueue_scripts');
//   } else {wp_die();}
// } add_action('admin_head','admin_field_inspector');


add_action('acf/render_field',function($field) {
  if (current_user_can('administrator')) {
    //echo $field['key'];
  }
  return $field;
});



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

// VARS

// Vars

function bp_set_var($key,$value) {
  $GLOBALS['wp_blueprint'][$key] = $value;
}

// TODO: accept key and fallback arrays
function bp_var($key,$fallback_value=null) {
  if (!isset($GLOBALS['wp_blueprint'])) {
    $GLOBALS['wp_blueprint'] = array();
  }
  if (isset($GLOBALS['wp_blueprint'][$key])) {
    return $GLOBALS['wp_blueprint'][$key];
  } else {
    if ($fallback_value !== null) {return $fallback_value;}
    else {return null;}
  }
}

// ENVIRONMENTS

function bp_is_local() {
  $host = $_SERVER['HTTP_HOST'];
  if ($host == 'localhost') {return true;}
  else {return false;}
}

// Turn off required fields for local development

if (bp_is_local()) {
  add_action('acf/load_field',function($field) {
    $field['required'] = false;
    return $field;
  });
}

// Lazy Loader Script

$lazy_loader = (new Blueprint\Enqueue\Script('bp_lazy_loader_script','lazy-loader.js',BP))
  ->addAjax();

// Site Search Script

$search_script = (new bp\Enqueue\Script('bp_script_search','search.js',BP))
  ->addAjax();

function bp_get_posts() {
  $offset = $_POST['query']['offset'];
  $cards = '';
  $args = array(
    's'         => $search,
    'post_type' => bp_var('article_types'),
    'offset'
  );
  $posts = get_posts($args); global $post;

  foreach ($posts as $post) : setup_postdata($post);
    $card = (new \Blueprint\Part\Card())->build();
    $cards .= "
      <div class='col-3'>
        $card
      </div>
    ";
  endforeach; wp_reset_postdata();
  echo $cards;
  wp_die();
}

function bp_get_part($base,$name=null) {
  ob_start();
  $part = get_template_part('parts/' . $base,$name);

  return ob_get_clean();
}

add_action( 'wp_ajax_bp_contact_form', 'bp_contact_form' );
add_action( 'wp_ajax_nopriv_bp_contact_form', 'bp_contact_form');

function bp_contact_form() {

  $form    = '';
  $site    = get_bloginfo('name');

  parse_str($_POST['form'],$form);

  // User Email
  $subject = "$site (Submission Confirmation)";
  $message = "Thanks for contacting $site. We'll be in touch soon!";
  $user_email  = wp_mail('aofolts@gmail.com',$subject,$message);

  // Admin Email

  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\n";
  $headers .= 'From: Great Dames <sender@example.com>' . "\n";

  $email   = $form['email'];
  $name    = $form['name'];
  $subject = str_replace('_',' ',$form['subject']);
  $subject = ucwords($subject);
  $subject = "New $site Message ($subject)";
  $message = $form['message'];
  $message = "
    <html>
      <body>
        <p><b>Email:</b> $email</p>
        <p><b>Name:</b> $name</p>
        <p><b>Message</b></p>
        <p>$message</p>
      </body>
    </html>
  ";
  $admin_email = wp_mail('aofolts@gmail.com',$subject,$message,$headers);

  if ($user_email && $admin_email) {echo 'Message sent!';}
  else {echo 'There was a problem sending your message.';}

  wp_die();

}

// Word Count

function limit_words($text,$limit=200) {
  $trunc = substr($text,0,200);
  $trunc = explode(' ',$trunc);
  array_pop($trunc);
  $trunc = implode(' ',$trunc) . ' ...';
  return $trunc;
}

add_action( 'wp_ajax_bp_ajax_load_posts', 'bp_ajax_load_posts' );
add_action( 'wp_ajax_nopriv_bp_ajax_load_posts', 'bp_ajax_load_posts');

function bp_ajax_load_posts() {

  $args = $_POST['query_vars'];
  $return = array();
  $paged = $args['paged'];

  if (!is_int($paged) || $paged < 1) {$paged = 1;}
  $args['paged'] = $paged + 1;

  $args['nopaging'] = false;
  global $wp_query;
  $wp_query = new \WP_Query($args);
  global $post;


  $posts = '';

  if (have_posts()) :

    while (have_posts()) : the_post();

      $posts.= (new part\Card())
        ->build();

    endwhile;

  else :
    echo 'no posts';
  endif;

  // Next
  $args['paged'] += 1;
  $next = new \WP_Query($args);


  $return['posts'] = $posts;
  $return['query'] = $wp_query;
  $return['next']  = $next->have_posts();

  echo json_encode($return);

  wp_die();

}

function my_acf_update_value($value,$post_id,$field) {
  $key = $field['name'];
  if (preg_match("/button.*link$/",$key)) {
    $type = str_replace('_link','',$key);
    $type = strstr($type,'button_');
    $type = str_replace('button_','',$type);
    $link_key = str_replace('_' . $type . '_','_',$key);
    update_post_meta($post_id,$link_key,$value);
  }
  return $value;
} add_filter('acf/update_value', 'my_acf_update_value', 10, 3);

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}
