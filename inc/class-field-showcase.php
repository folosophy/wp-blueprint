<?php

namespace Blueprint\Acf;

class Field_Showcase extends Field_Repeater {

  function __construct($name) {
    parent::__construct($name);
    $this->setFields();
    $this->setMin(3);
  }

  private function setFields() {
    $this->addHeadline();
  }

}
