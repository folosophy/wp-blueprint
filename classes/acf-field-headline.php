<?php

namespace Blueprint\Acf;

class Field_Headline extends Field_Text {

  function __construct($name) {
    parent::__construct($name);
    $this->setMaxLength(25);
  }

}
