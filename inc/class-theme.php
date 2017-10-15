<?php

namespace Blueprint;

class Theme {

  function __construct() {
    if (!is_admin()) {$this->loadPublic();}
    else {$this->loadAdmin();}
    $this->loadCore();
  }

  function create() {

  }

  private function loadPublic() {
    bp_glob_require('inc/public-core*');
    $this->enqueueStyle();
  }

  protected function loadCore() {
    bp_glob_require('inc/admin-core*');
  }

  private function loadAdmin() {
    bp_glob_require('inc/admin-core*');
  }

  protected function enqueueStyle() {
    $style = (new EnqueueStyle('theme_style','style.css'))
      ->addAction();
  }

  use Theme\Settings;

}
