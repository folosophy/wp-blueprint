<?php

namespace Blueprint\Part;

class Spacer extends Part {

  protected $height;

  function init() {
    $this->setTag('hr');
  }

  function setHeight($height = 'medium') {
    $this->setClass('spacer-' . $height);
    return $this;
  }

  function buildInit() {
    if (!$this->height) {$this->setHeight();}
  }

}
