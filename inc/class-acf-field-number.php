<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class Number extends acf\Field {

  function init() {
    $this->setType('number');
    $this->setMin(0);
  }

  function setPlaceholder($placeholder=null) {
    $this->field['placeholder'] = $placeholder;
    return $this;
  }

  function setAppend($append) {
    $this->field['append'] = $append;
    return $this;
  }

  function setPrepend($prepend) {
    $this->field['prepend'] = $prepend;
    return $this;
  }

  function setMin($num) {
    $this->field['min'] = $num;
    return $this;
  }

  function setMax($num) {
    $this->field['max'] = $num;
    return $this;
  }

  function setStep($step) {
    $this->field['step'] = $step;
    return $this;
  }

}
