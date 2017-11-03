<?php

/**
 * Plugin Name: WP Blueprint
 * Description: A Wordpress content and functionality library
 * Author: Sherpa Design Co.
 * Author URI: http://sherpadesign.co
 * Version: 1.0
 * Plugin URI:
 * License: GPL2+
 */

// Constants

define('BP','wp-blueprint');
define('BP_PATH',WP_PLUGIN_DIR . '/wp-blueprint');
define('BP_REL_PATH','/wp-content/plugins/wp-blueprint');
define('BP_VERSION','2.0');

// Aliases

class_alias('Blueprint','bp');

// Main Plugin Class

class Blueprint {

  static function init() {
    //$blueprint = new self();
    //add_action('init',array($blueprint,'run'));
    $self = new self();
    $self->run();
  }

  private function run() {
    $this->load();
  }

  private function load() {
    bp_require('inc/autoload',BP);
    bp_require('inc/menus',BP);
    bp_require('inc/testing',BP);
    bp_glob_require('inc/theme-core*',BP);
    if (is_admin()) {bp_glob_require('inc/admin-core*',BP);}
    else {
      bp_glob_require('inc/public-core*',BP);
    }
    bp_glob_require('inc/core*',BP);
    // TODO: require actions automatically
    bp_require('inc/acf-core-fields',BP);
    add_action('init',function() {
      bp_glob_require('inc/fields*');
    });
  }

}

if (function_exists('acf_add_local_field_group')) {
  Blueprint::init();
}

// TODO: Move to own file

// Glob Require
function bp_glob_require($pattern,$plugin=false) {
  if (!$plugin) {$base = get_template_directory();}
  else {$base = WP_PLUGIN_DIR . '/' . $plugin;}
  if (strpos($pattern,'.php')) {require $pattern;}
  else {
    if (strpos($pattern,'*')) {$pattern .= '.php';}
    else {$pattern .= '/*.php';}
    $glob = glob($base . '/' . $pattern);
    foreach ($glob as $file) {
      require $file;
    }
  }
}

function bp_require($file,$plugin=false) {
  if (!$plugin) {$base = get_template_directory();}
  else {$base = WP_PLUGIN_DIR . '/' . $plugin;}
  $file = $base . '/' . $file . '.php';
  require($file);
}
