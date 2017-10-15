<?php

namespace Blueprint\Acf\Field;

class Select extends Choice {

  protected function init() {
    $this->setType('select');
    $this->setReturnFormat();
  }

  function endSelect() {
    return $this->end();
  }

}
