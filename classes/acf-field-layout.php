<?php

namespace Blueprint\Acf\Field;
use \Blueprint as bp;
use \Blueprint\Acf as acf;

class Layout extends acf\Field\Group {

  function setMin($num) {
    $this->field['min'] = $num;
    return $this;
  }

  function setMax($num) {
    $this->field['max'] = $num;
    return $this;
  }

}
