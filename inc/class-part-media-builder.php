<?php

namespace Blueprint\Part;

trait MediaBuilder {

  protected $args;

  function setArgs($args) {
    foreach ($args as $key => $val) {
      $this->$key = $val;
    }
    return $this;
  }

}
