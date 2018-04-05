<?php

use Blueprint as bp;
use Blueprint\Enqueue as enqueue;
use \Blueprint\Part as part;

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
  // add_action('acf/load_field',function($field) {
  //   $field['required'] = false;
  //   return $field;
  // });
}

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

function bp_get_part($base,$name=null,$plugin=null) {
  ob_start();
  get_template_part('parts/' . $base,$name);
  return ob_get_clean();
}



// Word Count

function limit_words($text,$limit=200) {
  $trunc = substr($text,0,$limit);
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
  $args['nopaging'] = false;

  if ((int) $paged < 2) {$args['paged'] = 2;}

  global $wp_query;
  global $post;
  $wp_query = new \WP_Query($args);

  $posts = '';

  if (have_posts()) :

    while (have_posts()) : the_post();

      $posts.= bp_get_part('card',get_post_type());

    endwhile;

  else :
    $return['error'] = array();
    $return['error']['type'] = 'no_posts';
  endif;

  // Next
  $args['paged'] += 1;
  $next = new \WP_Query($args);


  $return['posts'] = $posts;
  $return['query'] = $next;
  $return['query_vars'] = $next->query_vars;
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

function bp_change_field_key($key,$new_key,$post_id=null) {
  if (!$post_id) {$post_id = get_the_ID();}
  $val      = get_field($key);
  if ($val) {
    $_val     = 'field_' . $new_key;
    $_key     = '_' . $key;
    $_new_key = '_' . $new_key;
    update_post_meta($post_id,$new_key,$val);
    update_post_meta($post_id,$_new_key,$_val);
    // delete_post_meta($post_id,$key);
    // delete_post_meta($post_id,$_key);
  }
}

function bp_prefix_field_keys($prefix,$keys,$args) {
  $posts = get_posts($args); global $post;
  foreach ($posts as $post) : setup_postdata($post);
    foreach($keys as $key) {
      $new_key = $prefix . '_' . $key;
      bp_change_field_key($key,$new_key);
    }
  endforeach; wp_reset_postdata();
  wp_die('Ran');
}

// bp_prefix_field_keys(
//   'dame',
//   array('video','video','video_youtube_id','video_vimeo_id','video_thumbnail','video_source'),
//   array('post_type'=>'dame')
// );

function bp_get_pto($post_type=null) {
  if (!$post_type) {$post_type = get_post_type();}
  return get_post_type_object($post_type);
}

function bp_get_video_thumbnail($host=null,$video_id=null,$post_id=null) {
  if (!$video_id) {
    $host = get_field('featured_media_video_host',$post_id);
  }
  switch ($host) {
    case 'youtube' :
      $video_id = get_field('featured_media_video_youtube_id');
      $url = "http://img.youtube.com/vi/$video_id/sddefault.jpg";
      break;
    default :
      $url = null;
  }
  return $url;
}

// Hide admin bar
// TODO: way to toggle for admins/editors, etc

show_admin_bar(false);

$cat = (new bp\Taxonomy('event_category'))
  ->setPostType('event')
  ->setMetaBox(false)
  ->setHierarchical(false);

remove_filter ('acf_the_content', 'wpautop');
