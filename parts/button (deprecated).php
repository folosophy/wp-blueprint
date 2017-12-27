<?php

namespace Blueprint\Part;

class Button extends Part {

  protected $class;
  protected $link;
  protected $label;
  protected $style;
  protected $target;

  function init() {
    $this->setTag('a');
  }

  function getLabel() {
    if (!isset($this->label)) {$this->setLabel();}
    return $this->label;
  }

  function getType() {
    if (!isset($this->type)) {$this->setType();}
    return $this->type;
  }

  function setLabel($label='Learn More') {
    $this->label = $label;
    return $this;
  }

  function setType($type='primary') {
    $this->type = 'btn-' . $type;
    return $this;
  }



  // function __construct($style=null,$label=null,$link=null,$newTab=false) {
  //   $this->setStyle($style);
  //   $this->setLabel($label);
  //   $this->setlink($link);
  //   $this->setNewTab($newTab);
  // }
  //
  // public function setStyle($style) {
  //   $this->style = $style;
  //   $class       = 'btn-' . $style;
  //   $this->setClass($class);
  //   return $this;
  // }
  //
  // public function setClass($class) {
  //   $this->class = $class;
  //   return $this;
  // }
  //
  // public function setLabel($label) {
  //   $this->label = $label;
  //   return $this;
  // }
  //
  // public function setNewTab($newTab = true) {
  //   if ($newTab) {$this->target = "target='_blank'";}
  //   return $this;
  // }
  //
  // function setLink($link) {
  //   $this->link = $link;
  //   return $this;
  // }
  //
  // public function build() {
  //   $class  = $this->class;
  //   $label  = $this->label;
  //   $link   = $this->link;
  //   $target = $this->target;
  //   return "<a class='$class' href='$link' $target>$label</a>";
  // }

  function buildInit() {
    
  }

}
