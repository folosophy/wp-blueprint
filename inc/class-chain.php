<?php

namespace Blueprint;

trait Chain {

  protected $parentInstance;

  function chainInit($parentInstance) {
    $this->setParentInstance($parentInstance);
  }

  function getParent() {
    return $this->parentInstance;
  }

  function setParent($parentInstance) {
    $this->parentInstance = $parentInstance;
    return $this;
  }

  function setParentInstance($parentInstance) {
    $this->parentInstance = $parentInstance;
  }

  function endChain() {
    return $this->parentInstance;
  }

  function end() {
    return $this->parentInstance;
  }

  function dumpThis() {
    wp_die(var_dump($this));
  }

  function chain($obj,$chain=false) {
    if (is_object($obj)) {
      $obj->setParentInstance($this);
    } else {wp_die('chain expects object.');}
    if (!$chain) {return $this;}
    else {return $obj;}
  }

}
