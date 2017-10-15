<?php

namespace Blueprint\Group\Preset;

class Showcase extends Group {

  function __construct($name) {
    parent::__construct($name);
    $this->setFields();
  }

  private function setFields() {
    $field = new Field_Repeater('services');
    $field = $field->getField();
    $this->addField($field);
  }

}
