<?php

namespace Blueprint\Acf\Field;
use \Blueprint\acf as acf;

class Message extends acf\Field {

  protected $choices;

  function init() {
    $this->setType('message');
  }

  function setMessage($message) {
    $this->field['message'] = $message;
    return $this;
  }

}
