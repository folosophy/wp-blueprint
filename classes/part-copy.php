<?php

namespace Blueprint\Part;

class Copy extends Text {

  function init() {
    parent::init();
    $this->addClass('copy');
    $this->setTag('div');
  }

  function setText($text=null) {
    if ($this->field) {
      $field = $this->field;
      if (isset($this->field['copy'])) {$text = $this->field['copy'];}
      elseif (is_string($field)) {$text = $this->field;}
    }
    return parent::setText($text);
  }

}
