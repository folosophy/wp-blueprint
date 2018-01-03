<?php

namespace Blueprint\Part;

class Button extends Part {

  protected $buttonField;
  protected $class;
  protected $link;
  protected $label;
  protected $style;
  protected $target;
  protected $type;

  function init() {
    $this->setTag('a');
    $this->addClass('lazy-item lazy-unloaded');
  }

  function getLabel() {
    if (!isset($this->label)) {$this->setLabel();}
    return $this->label;
  }

  function getType() {
    if (!isset($this->type)) {$this->setType();}
    return $this->type;
  }

  function setField($field=null) {
    parent::setField($field);
    if (isset($field['button'])) {
      $this->field = $field['button'];
    }
    return $this;
  }

  function setLabel($label='Learn More') {
    if ($label) {
    } elseif ($this->field && isset($this->field['label'])) {
      $label = $this->field['label'];
    }
    $this->label = $label;
    return $this;
  }

  function setType($type='primary') {
    $this->type = 'btn-' . $type;
    return $this;
  }

  function buildInit() {
    if (empty($this->getAttr('href'))) {$this->setLink();}
    if (!$this->label) {$this->setLabel();}
    if ($this->type) {$this->addClass($this->type);}
    $this->addHtml($this->label);
  }

}
