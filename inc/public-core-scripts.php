<?php

use Blueprint\Enqueue as Enqueue;

$nav_script = (new Enqueue\Script('bp_nav_script','nav.js',BP))
  ->addLocalize('SITEURL',get_option('siteurl'));

  function bp_head_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('bp_mailer_script',BP_REL_PATH . '/assets/js/mailer.js');
  } add_action('wp_enqueue_scripts','bp_head_scripts');

  $mailer_script = (new Enqueue\Script('bp_mailer_script','mailer.js',BP))
    ->addAjax();



// Lazy Loader Script

$lazy_loader = (new Enqueue\Script('bp_lazy_loader_script','lazy-loader.js',BP))
  ->addAjax();

// Site Search Script

if (bp_var('search') === true) {
  $search_script = (new Enqueue\Script('bp_script_search','search.js',BP))
    ->addAjax();
}
