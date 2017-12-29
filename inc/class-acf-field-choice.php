<?php

namespace Blueprint\Acf\Field;
use \Blueprint\acf as acf;

class Choice extends acf\Field {

  protected $choices;

  protected function init() {
    $this->field['type'] = 'select';
    wp_die($this->field);
  }

  function allowNull($bool=true) {
    $this->field['allow_null'] = $bool;
    return $this;
  }

  function setChoices($choices) {
    if (!$choices) {wp_die('Needs choices.');}
    if (is_string($choices)) {
      $choices = array($choices);
      //TODO: Rethink
      //if (count($choices) == 1) {$this->parent->hideGroup();}
    }
    $formatted_choices = array();
    foreach ($choices as $key => $val) {
      if (is_int($key)) {
        $key = $val;
      }
      $key = strtolower($key);
      $val = ucwords($val);
      $formatted_choices[$key] = $val;
    }
    $this->field['choices'] = $formatted_choices;
    return $this;
  }

  function setReturnFormat($format='value') {
    $this->field['return_format'] = $format;
  }

}
