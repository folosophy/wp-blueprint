<?php

namespace Blueprint;

class ShortcodeOptions {

  protected $type;

  static function run() {
    wp_die();
  }

  static function addAction() {
    add_action('wp_ajax_test',array(__CLASS__,'run');
  }

}
