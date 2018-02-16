<?php

namespace Blueprint;

class LocalizeScript {

  protected $handle;
  protected $name;

  function __construct($handle) {
    $this->handle = $handle;
    $this->setName($handle);
  }

  function setName($handle) {
    $this->name = $handle . '_object';
  }

  protected function localize() {
    wp_localize_script(
      $this->handle,
      $this->name,
      array('ajax_url' => admin_url( 'admin-ajax.php'))
    );
  }

  function addAction($action='admin_enqueue_scripts') {
    add_action($action,array($this,'localize'));
  }

}
