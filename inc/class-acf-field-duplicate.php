<?php

namespace Blueprint\Acf\Field;
use \Blueprint\Acf\Field as Field;

class Duplicate extends Field {

  function init() {
    $this->setType('clone');
    $this->setRequired(false);
  }

  function addClone($keys) {
    if (is_string($keys)) {$keys = array($keys);}
    $this->field['clone'] = $keys;
    return $this;
  }

  function prefixName($prefix=true) {
    if ($prefix) {$this->field['prefix_name'] = 1;}
    return $this;
  }

  function setDisplay($display='group') {
    $choices = array('group','seamless');
    if (!in_array($display,$choices)) {
      $this->throwInputError('group or seamless');
    }
    $this->field['display'] = $display;
    return $this;
  }

  function setKey($key) {
    $key = $this->name . '_clone';
    parent::setKey($key);
  }

  function setRequired($required=1) {
    parent::setRequired();
    $this->setDisplay('group');
    return $this;
  }

}
