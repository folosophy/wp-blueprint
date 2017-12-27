<?php

namespace Blueprint\Part;

class Icon extends Part {

  protected $file;

  protected function init() {
    $this->setTag('img');
  }

  function setFile($file=null) {
    $this->file = $file;
  }

  function setSrc() {
    if (!$this->file) {$this->file = $this->name . '.svg';}
    $src = get_template_directory_uri() . '/assets/img/icon-' . $this->file;
    $this->setAttr('src',$src);
    return $this;
  }

  protected function buildInit() {
    if (!isset($this->atts['src'])) {$this->setSrc();}

  }

}
