<?php

namespace Blueprint\Part;

class Spacer extends Part {

  protected $height;

  function init() {
    if ($this->name) {$this->setHeight($this->name);}
    $this->setTag('hr');
  }

  function setHeight($height = 'medium') {
    $this->setClass('spacer-' . $height);
    $this->height = $height;
    return $this;
  }

  function buildInit() {
    if (!$this->height) {$this->setHeight();}
  }

}
