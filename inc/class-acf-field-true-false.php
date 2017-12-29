<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class TrueFalse extends acf\Field {

  function init() {
    $this->setType('true_false');
    $this->setUI();
    $this->setDefaultValue(0);
  }

  function endTrueFalse() {
    return $this->end();
  }

  function setMessage($message) {
    $this->field['message'] = $message;
    return $this;
  }

  function setUI($ui = 1) {
    if (!is_int($ui)) {wp_die(__FUNCTION__ . 'expects int.');}
    $this->field['ui'] = $ui;
    return $this;
  }

  function setLabels($on,$off) {
    if (!is_int($on) || !is_int($off)) {throwInputError('int');}
    $this->field['ui_on_text'] = $on;
    $this->field['ui_off_text'] = $off;
  }

}
