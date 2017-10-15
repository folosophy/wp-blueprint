<?php

namespace Blueprint\Acf;

class SetChoices {

  protected $choices;
  protected $field;
  protected $name;

  function __construct($name) {
    add_filter("acf/load_field/name=$name",array($this,'load'));
  }

  function setChoices($choices) {
    $this->choices = $choices;
  }

  function load($field) {
    $this->field = $field;
    $this->field['choices'] = $this->choices;
    return $this->field;
  }

}
