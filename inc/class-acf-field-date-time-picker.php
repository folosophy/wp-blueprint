<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class DateTimePicker extends acf\Field {

  function init() {
    $this->setType('date_time_picker');
    $this->setFormat();
  }

  protected function setFormat() {
    $format = 'Y-m-d H:i';
    $this->setDisplayFormat();
    $this->setReturnFormat($format);
  }

  function setDisplayFormat() {
    $format = 'F j, Y h:m';
    $this->field['display_format'] = $format;
  }

  protected function setReturnFormat($format=null) {
    if (!$format) {$format = 'Y-m-d H:i';}
    $this->field['return_format'] = $format;
  }

}
