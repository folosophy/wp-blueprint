<?php

namespace Blueprint\Acf\Field;

class Checkbox extends Choice {

  protected function init() {
    $this->setType('checkbox');
  }

}
