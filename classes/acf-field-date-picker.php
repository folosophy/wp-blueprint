<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class DatePicker extends acf\Field {

  function init() {
    $this->setType('date_picker');
    $this->setFormats();
  }

  protected function setFormats() {
    $this->setDisplayFormat();
    $this->setReturnFormat();
  }

  function setDisplayFormat() {
    $format = 'F j, Y';
    $this->field['display_format'] = $format;
  }

  protected function setReturnFormat($format=null) {
    if (!$format) {$format = 'Y-m-d';}
    $this->field['return_format'] = $format;
  }

}
