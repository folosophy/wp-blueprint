<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class Text extends acf\Field {

  function init() {
    $this->setType('text');
  }

  function endText() {
    return $this->end();
  }

  function setMaxLength($length) {
    $this->field['maxlength'] = $length;
    return $this;
  }

  function setPrepend($prepend) {
    $this->field['prepend'] = $prepend;
    return $this;
  }

  function setPlaceholder($text) {
    $this->field['placeholder'] = $text;
    return $this;
  }

}
