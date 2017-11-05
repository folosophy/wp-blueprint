<?php

namespace Blueprint;

trait Chain {

  protected $parent;

  function chainInit($parent) {
    $this->setParent($parent);
  }

  function getParent() {
    return $this->parent;
  }

  function setParent($parent) {
    $this->parent = $parent;
    return $this;
  }

  function endChain() {
    return $this->parent;
  }

  function end() {
    return $this->parent;
  }

  function dumpThis() {
    wp_die(var_dump($this));
  }

  function chain($obj,$chain=false) {
    if (is_object($obj)) {
      $obj->setparent($this);
    } else {wp_die('chain expects object.');}
    if (!$chain) {return $this;}
    else {return $obj;}
  }

}
