<?php

namespace Blueprint\Part;

class Button extends Part {

  protected $type;
  protected $class;
  protected $id;
  protected $label;
  protected $link;

  function __construct($type='light',$label='Learn More',$link='#section-next') {
    $this->type = $type;
    $this->label = $label;
    $this->link = $link;
    $this->setClass();
  }

  function addClass($class) {
    $this->class .= ' ' . $class;
    return $this;
  }

  function setClass($class=null) {
    $this->class = 'btn-' . $this->type . ' ' . $class . ' ';
    return $this;
  }

  function setLink($link) {
    $this->link = $link;
    return $this;
  }

  function build() {
    return "
      <a href='$this->link' class='$this->class'>$this->label</a>
    ";
  }

}
