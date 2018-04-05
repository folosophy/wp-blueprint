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

    $name = $this->name;
    if (is_array($name)) {$this->setField($name);}

    $this->setTag('a');
    $this->setType('primary');

    $this->setLazy(true);

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
      $field = $field['button'];
    }
    if (isset($field['link_type'])) {
      $link_type = $field['link_type'];
      $link = $field[$link_type . '_link'];
      $this->setLink($link,$link_type);
      $this->setLabel($field['label']);
    }
    return $this;
  }

  function setLabel($label=null) {
    if (!$label) {
      if ($this->name) {
        $label = $this->name;
      } elseif ($this->field && isset($this->field['label'])) {
        $label = $this->field['label'];
      } else {
        $label = 'Learn More';
      }
    }
    $this->label = $label;
    return $this;
  }

  function setType($type=null) {
    if ($type === false) {$type = null;}
    else {$type = 'btn-' . $type . ' button-' . $type;}
    $this->type = $type;
    return $this;
  }

  function buildInit() {
    if (empty($this->getAttr('href'))) {
      $this->setLink();
    }
    if (!$this->label) {$this->setLabel();}
    if ($this->type) {$this->addClass($this->type);}
    $this->addHtml($this->label);

    if ($this->lazy) {$this->addClass('lazy-button');}

  }

}
