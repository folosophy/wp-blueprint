<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class Url extends acf\Field\Text {

  function init() {
    $this->setType('url');
  }

  function endUrl() {
    return $this->end();
  }

}
