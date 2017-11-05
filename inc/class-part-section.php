<?php

namespace Blueprint\Part;

class Section extends Part {

  protected $body;
  protected $id='';
  protected $name;
  protected $headline;
  protected $theme;
  protected $wrap;

  protected function init() {
    $this->setId();
    $this->setField();
    $this->setTag('section');
    //diedump($this->field);
  }

  function setBody($body=null) {
    $this->body = $body;
    return $this;
  }

  function setClass($class) {
    $this->class = $class;
    return $this;
  }

  function setId($id=null) {
    if (!$id) {$id = 'section-' . $this->name;}
    $this->id .= $id;
  }

  function setTheme($theme='trans') {
    $theme = 'theme-' . $theme;
    $this->theme = $theme;
    return $this;
  }

}
