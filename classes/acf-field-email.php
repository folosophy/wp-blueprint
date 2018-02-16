<?php

namespace Blueprint\Acf\Field;
use \Blueprint\Acf\Field as Field;

class Email extends Field {

  function init() {
    $this->setType('email');
  }

  function setPlaceholder($placeholder='example@website.com') {
    $this->field['placeholder'] = $placeholder;
  }

}
