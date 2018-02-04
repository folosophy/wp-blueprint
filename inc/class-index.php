<?php

namespace Blueprint;

class Index {

  protected $template;

  function __construct() {

  }

  function loadTemplate() {
    // TODO: mimic get_template_part, if null, then use BP class
    wp_reset_query();
    global $post;
    $template = null;
    if (is_page()) {
      $template = apply_filters('bp_page_template',$template);
      if (!$template) {
        $template = bp_get_part('page',$post->post_name);
      }
    }
    elseif (is_single()) {
      $template = bp_get_part('single',get_post_type());
    }
    elseif (is_404()) {
      $template = bp_get_part('404');
    } elseif (is_search()) {
      $template = bp_get_part('search');
    }

    if ($template) {echo $template;}
    else {wp_die('No tempalte');}

  }

  function render() {
    $this->loadTemplate();
  }

}
