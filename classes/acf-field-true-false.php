<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class TrueFalse extends acf\Field {

  function init() {
    $this->setType('true_false');
    $this->setUI();
    $this->setDefaultValue(0);
    $this->setRequired(0);
  }

  function setMessage($message) {
    $this->field['message'] = $message;
    return $this;
  }

  function setUI($ui=true) {
    $this->field['ui'] = (bool) $ui;
    return $this;
  }

  function setLabels($on,$off) {
    if (!is_int($on) || !is_int($off)) {throwInputError('int');}
    $this->field['ui_on_text'] = $on;
    $this->field['ui_off_text'] = $off;
  }

}
