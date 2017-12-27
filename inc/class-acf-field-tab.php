<?php

namespace Blueprint\Acf\Field;
use \Blueprint\acf as acf;

class Tab extends acf\Field {

  protected $choices;

  protected function init() {
    $this->field['type'] = 'tab';
  }

  function setKey($key) {
    $key = 'tab_' . $key;
    parent::setKey($key);
  }

  function setPlacement($placement='top') {
    $options = array('left','top');
    if (!in_array($placement,$options)) {wp_die('setPlacement expects left or top.');}

  }

  // setEndpoint

}
