<?php

namespace Blueprint\Acf\Field;
use \Blueprint as bp;
use \Blueprint\Acf as acf;

class FlexibleContent extends acf\Field {

  protected $layouts = array();

  use acf\FieldBuilder;

  function init() {
    $this->setType('flexible_content');
    $this->addClass('nolabel');
  }

  function addLayout($name) {
    $layout = (new Layout($name,$this));
    array_push($this->layouts,$layout);
    return $layout;
  }

  function getLayouts() {
    $layouts = array();
    foreach ($this->layouts as $layout) {
      $layout = $layout->getField();
      array_push($layouts,$layout);
    }
    return $layouts;
  }

  function getField() {
    $field = parent::getField();
    $field['layouts'] = $this->getLayouts();
    return $field;
  }

  function setButtonLabel($label) {
    $this->field['button_label'] = $label;
    return $this;
  }

}
