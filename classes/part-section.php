<?php

namespace Blueprint\Part;

class Section extends Part {

  protected $bg;
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
  }

  function getBg() {
    return $this->checkSet('bg');
  }

  function setBg() {
    $this->bg = (new Image())
      ->setClass('section__bg');
  }

  function setBody($body=null) {
    $this->body = $body;
    return $this;
  }

  function setCollapse($dir) {
    $this->addClass('collapse-' . $dir);
    return $this;
  }

  function setId($id=null) {
    if (!$id) {$id = 'section-' . $this->name;}
    $this->atts['id'] = $id;
    return $this;
  }

  function setMargin($margin) {
    $this->addClass('margin-' . $margin);
    return $this;
  }

  function setTheme($theme='trans') {
    $theme = 'theme-' . $theme;
    $this->theme = $theme;
    return $this;
  }

  function buildInit() {
    if (isset($this->bg)) {$this->insertPartBefore($this->getBg());}
    if ($this->theme) {$this->addClass($this->theme);}
  }

}
