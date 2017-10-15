<?php

namespace Blueprint\Part;

class Button extends Part {

  protected $class;
  protected $link;
  protected $label;
  protected $style;
  protected $target;

  function __construct($style=null,$label=null,$link=null,$newTab=false) {
    $this->setStyle($style);
    $this->setLabel($label);
    $this->setlink($link);
    $this->setNewTab($newTab);
  }

  public function setstyle($style) {
    $this->style = $style;
    $class       = 'btn-' . $style;
    $this->setClass($class);
    return $this;
  }

  public function setClass($class) {
    $this->class = $class;
    return $this;
  }

  public function setLabel($label) {
    $this->label = $label;
    return $this;
  }

  public function setNewTab($newTab = true) {
    if ($newTab) {$this->target = "target='_blank'";}
    return $this;
  }

  public function setlink($link) {
    $this->link = $link;
    return $this;
  }

  public function build() {
    $class  = $this->class;
    $label  = $this->label;
    $link   = $this->link;
    $target = $this->target;
    return "<a class='$class' href='$link' $target>$label</a>";
  }

}
