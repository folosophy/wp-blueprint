<?php

namespace Blueprint\Acf;

class TrueFalse extends Choice {

  function setUi($on='On',$off='Off') {
    $this->field['ui'] = 1;
    $this->field['ui_on_text'] = $on;
    $this->field['ui_off_text'] = $off;
  }

}
