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
  }

  function getLabel() {
    if (!isset($this->label)) {$this->setLabel();}
    return $this->label;
  }

  function getType() {
    if (!isset($this->type)) {$this->setType();}
    return $this->type;
  }

  function setButtonField() {
    if ($this->field && isset($this->field['button'])) {
      $this->buttonField = $this->field['button'];
    }
    return $this;
  }

  function setLabel($label='Learn More') {
    if ($this->buttonField) {
      $label = $this->field['button']['label'];
    }
    $this->label = $label;
    return $this;
  }

  function setLink($link='#section-next') {
    if ($this->buttonField) {
      $field = $this->buttonField;
      switch ($this->buttonField['link_target']) {
        case 'internal': $link = get_permalink($field['internal_link']); break;
        case 'external': $link = $field['external_link']; break;
        case 'section':  $link = $field['section_link']; break;
      }
    }
    $this->setAttr('href',$link);
    return $this;
  }

  function setTarget($target='_blank') {
    $this->setAttr('target',$target);
  }

  function setType($type='primary') {
    $this->type = 'btn-' . $type;
    return $this;
  }

  function buildInit() {
    $this->setButtonField();
    if (!$this->label) {$this->setLabel();}
    if (!isset($this->atts['href'])) {$this->setLink();}
    if ($this->type) {$this->addClass($this->type);}
    $this->addHtml($this->label);
  }

  // function __construct($style=null,$label=null,$link=null,$newTab=false) {
  //   $this->setStyle($style);
  //   $this->setLabel($label);
  //   $this->setlink($link);
  //   $this->setNewTab($newTab);
  // }
  //
  // public function setStyle($style) {
  //   $this->style = $style;
  //   $class       = 'btn-' . $style;
  //   $this->setClass($class);
  //   return $this;
  // }
  //
  // public function setClass($class) {
  //   $this->class = $class;
  //   return $this;
  // }
  //
  // public function setLabel($label) {
  //   $this->label = $label;
  //   return $this;
  // }
  //
  // public function setNewTab($newTab = true) {
  //   if ($newTab) {$this->target = "target='_blank'";}
  //   return $this;
  // }
  //
  // function setLink($link) {
  //   $this->link = $link;
  //   return $this;
  // }
  //
  // public function build() {
  //   $class  = $this->class;
  //   $label  = $this->label;
  //   $link   = $this->link;
  //   $target = $this->target;
  //   return "<a class='$class' href='$link' $target>$label</a>";
  // }

}
