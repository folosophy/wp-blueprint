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
      $template = get_field('template');
      if ($template == 'default' || !$template) {$template = 'page';}
      $template = bp_get_part($template);
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
