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

  function setClass($class=null) {
    $this->class = $class;
    return $this;
  }

  function setId($id=null) {
    if (!$id) {$id = 'section-' . $this->name;}
    $this->atts['id'] = $id;
    return $this;
  }

  function setTheme($theme='trans') {
    $theme = 'theme-' . $theme;
    $this->theme = $theme;
    return $this;
  }

  function buildInit() {
    if (!$this->theme) {$this->setTheme();}
    $this->addClass($this->theme);
  }

}
