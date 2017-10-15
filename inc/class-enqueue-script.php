<?php

namespace Blueprint;

class EnqueueScript extends Enqueue {

  function enqueue() {
    wp_enqueue_script($this->name,$this->src,$this->dependencies,$this->version,$this->footer);
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
