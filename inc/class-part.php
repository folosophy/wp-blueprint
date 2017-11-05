<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class Part {

  use Builder;

  function __construct($name='',$parent=null) {
    if (strpos($name,'-')) {
      $name = explode('-',$name);
      $this->prefix = $name[0] . '_';
      $this->name = $name[1];
    } else {
      $this->name= $name;
    }
    $this->title = ucwords($this->name);
    if ($parent) {
      $this->setParent($parent);
      if (isset($this->parent) && method_exists($parent,'getField')) {
        $this->field = $parent->getField();
      }
    }
    if (method_exists($this,'init')) {$this->init();}
  }

}
