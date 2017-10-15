<?php

namespace Blueprint\Media;

class Media {

  protected $args;

  function render() {
    echo $this->build();
  }

  function setArgs($args=null) {
    if ($args) {
      foreach ($args as $key => $val) {
        $this->$key = $val;
      }
    }
    return $this;
  }

}
