<?php

namespace Blueprint\Part;

class MenuMain extends Header {

  public $build;

  function __construct() {
    parent::__construct();
  }

  public function getBuild() {
    ob_start();
    wp_nav_menu(
      array(
        'theme_location'=>'main',
        'menu_class'     => 'menu-main',
        'menu_id' => 'menu-main',
        'container' => false,
        'walker' => new WalkerMenuMain()
      )
    );
    return ob_get_clean();
  }

}
