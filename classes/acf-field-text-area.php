<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class TextArea extends acf\Field {

  function init() {
    $this->setType('textarea');
    $this->setRows();
  }

  function setMaxLength($length) {
    $this->field['maxlength'] = $length;
    return $this;
  }

  function setRows($rows=3) {
    $this->field['rows'] = $rows;
    return $this;
  }

}
