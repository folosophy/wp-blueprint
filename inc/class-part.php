<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class Part {

  use bp\Chain;
  use bp\Media\Builder;

  protected $name;
  protected $build;
  protected $fieldGroup;
  protected $parts = array();
  protected $prefix;
  protected $class='';

  function __construct($name='',$parent=null) {

    if (strpos($name,'-')) {
      $name = explode('-',$name);
      $this->prefix = $name[0] . '_';
      $this->name = $name[1];
    } else {
      $this->name= $name;
    }
    $this->title = ucwords($this->name);
    if (method_exists($this,'init')) {$this->init();}
  }

  function setAlign($align='center') {
    $this->class .= $align;
    return $this;
  }

  function addButton() {
    $button = $this->fieldGroup['button'];
    $part = (new Button('light',$field['label'],''));
    $this->addPart($part);
  }

  function addClass($class) {
    $this->class .= ' ' . $class;
    return $this;
  }

  function addCopy($copy=null) {
    if (!$copy) {
      $copy = $this->fieldGroup['copy'];
      $this->addPart($copy);
    }
    return $this;
  }

  function addHeadline($headline=null) {
    if (!$headline) {
      if ($this->fieldGroup['headline']) {$headline = $this->fieldGroup['headline'];}
      else {$headline = ucwords($this->name);}
    }
    $this->addPart("<h2>$headline</h2>");
    return $this;
  }

  function addPart($part=null,$chain=false) {
    if (!$part) {
      $part = (new Part())
        ->setParent($this)
        ->setFieldGroup($this->getFieldGroup());
      $chain = true;
    }
    array_push($this->parts,$part);
    if ($chain) {return $part;}
    else {return $this;}
  }

  function setFieldGroup($fieldGroup=null) {
    if (!$fieldGroup) {
      $this->fieldGroup = get_field($this->prefix . $this->name);
    } else {$this->fieldGroup = $fieldGroup;}
    return $this;
  }

  function getFieldGroup() {
    return $this->fieldGroup;
  }

  function endPart() {
    return $this->end();
  }

  function build() {
    $parts = $this->buildParts();
    return "
      <div class='$this->class'>
        $parts
      </div>
    ";
  }

  function buildParts() {
    $parts = '';
    foreach($this->parts as $part) {
      if (is_object($part)) {
        $parts .= $part->build();
      } else {
        $parts .= $part;
      }
    }
    return $parts;
  }

  function render() {
    echo $this->build();
  }

}
