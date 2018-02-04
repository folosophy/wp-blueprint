<?php

namespace Blueprint\Acf\Field;

class Select extends Choice {

  protected function init() {
    $this->setType('select');
    $this->setReturnFormat();
    $this->setRequired(false);
  }

  function setAjax($ajax) {
    if ($ajax) {$this->field['ajax'] = 1;}
    return $this;
  }

  function setUi($ui) {
    if ($ui) {$this->field['ui'] = 1;}
    return $this;
  }

  function endSelect() {
    return $this->end();
  }

}
