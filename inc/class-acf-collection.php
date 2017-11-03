<?php

namespace Blueprint\Acf;

class Collection {

  protected $id;
  protected $groups = array();
  protected $prefix;

  function __construct($id) {
    $this->id = $id;
  }

  function addGroup($name) {
    $group = (new Group($name,$this))
      ->setLocation($this->id,'page');
    array_push($this->groups,$group);
    return $group;
  }

}
