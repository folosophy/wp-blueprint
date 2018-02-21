<?php

namespace Blueprint\Acf\Field;
use \Blueprint as bp;
use \Blueprint\Acf as acf;

class Layout extends acf\Field\Group {

  function init() {
    unset($this->field['type']);
  }

  function setLayout($layout='block') {
    $layouts = array('block','table','row');
    if (in_array($layout,$layouts)) {
      if (property_exists($this,'group')) {$this->group['layout'] = $layout;}
      else {$this->field['display'] = $layout;}
    }
    return $this;
  }

  function setMin($num) {
    $this->field['min'] = $num;
    return $this;
  }

  function setMax($num) {
    $this->field['max'] = $num;
    return $this;
  }

}
