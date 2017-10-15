<?php

namespace Blueprint\Acf\Field;
use \Blueprint\Acf\Field as Field;

class Duplicate extends Field {

  function init() {
    $this->setType('clone');
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

}
