<?php

namespace Blueprint\Acf\Field;
use \Blueprint as bp;
use \Blueprint\Acf as acf;

class Repeater extends acf\Field {

  use acf\FieldBuilder;

  protected $isGroupField;
  protected $fields = array();

  function init() {
    $this->setType('repeater');
  }

  function getField() {
    $this->field['sub_fields'] = array();
    foreach ($this->fields as $field) {
      $field = $field->getField();
      array_push($this->field['sub_fields'],$field);
    }
    return parent::getField();
  }

  function endRepeater() {
    return $this->end();
  }

  function getFields() {
    return $this->fields;
  }

  function setButtonLabel($label) {
    $this->field['button_label'] = $label;
    return $this;
  }

  function setMax($max) {
    if (!is_int($max)) {$this->throwInputError('int');}
    $this->field['max'] = $max;
    return $this;
  }

  function setMin($min) {
    if (!is_int($min)) {$this->throwInputError('int');}
    $this->field['min'] = $min;
    return $this;
  }

}
