<?php

namespace Blueprint\Enqueue;

class Script extends Enqueue {

  protected $ajax;
  protected $localize = array();

  function addAjax() {
    $this->ajax = true;
    return $this;
  }

  function addLocalize($varName,$vars) {
    $localize = array(
      'varName'    => $varName,
      'vars'       => $vars
    );
    array_push($this->localize,$localize);
  }

  function setInFooter() {
    $this->footer = true;
    return $this;
  }

  function enqueue() {
    parent::enqueue();
    wp_enqueue_script($this->name,$this->src,$this->dependencies,$this->version,$this->footer);
    if ($this->ajax == true) {$this->setAjax();}
    if ($this->localize) {
      foreach ($this->localize as $localize) {
        wp_localize_script(
          $this->name,
          $localize['varName'],
          $localize['vars']
        );
      }
    }
  }

  protected function setAjax() {
    wp_localize_script(
      $this->name,
      'ajax',
      array(
        'url' => admin_url('admin-ajax.php')
      )
    );
  }

  function setDependencies($deps=null) {
    if (!$deps) {$deps = array('jquery');}
    $this->dependencies = $deps;
    return $this;
  }

  function setType() {
    $this->type = 'js';
  }

}
