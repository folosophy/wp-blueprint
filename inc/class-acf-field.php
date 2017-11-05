<?php

namespace Blueprint\Acf;
use \Blueprint as bp;
use \Blueprint\Acf as acf;

class Field {

  use Builder;
  use bp\Chain;

  protected $name;
  protected $field = array();
  protected $hidden;
  protected $key;
  protected $logic;
  protected $prefix;

  function __construct($key,$parent) {
    $this->parent = $parent;
    $this->setName($key);
    $this->setPrefix();
    $this->setLabel();
    $this->field['wrapper'] = array();
    if (method_exists($this,'init')) {$this->init();}
    if ($this->field['type'] !== 'clone') {$this->field['required'] = 1;}
  }

  function dumpField() {
    diedump($this->field);
  }

  function getKey() {
    return $this->field['key'];
  }

  function getName() {
    return $this->field['name'];
  }

  function getParentKey() {
    if (is_subclass_of($this->parent,'Blueprint\Acf\Field')) {
      return $this->parent->getKey();
    } else {
      return null;
    }
  }

  function getType() {
    return $this->field['type'];
  }

  function setLogic($key=null,$value=null,$operator='==') {
    $logic = (new acf\Logic($this));
    $this->logic = $logic;
    if ($key && $value !== null) {
      $logic->addCondition($key,$value,$operator);
      return $this;
    } else {
      return $logic;
    }
  }

  protected function setPrefix() {
    $parent = $this->parent;
    if (is_subclass_of($parent,'Blueprint\Acf\Field')) {
      $this->prefix = $parent->getKey() . '_';
    } else {
      $this->prefix = 'field_';
    }
  }

  function getPrefix() {
    return $this->prefix;
  }

  function setClass($class) {
    $this->field['wrapper']['class'] = $class;
    return $this;
  }

  function addClass($class) {
    if (!isset($this->field['wrapper']['class'])) {
      $this->field['wrapper']['class'] = '';
    }
    $this->field['wrapper']['class'] .= " $class ";
  }

  function setDefaultValue($value) {
    $this->field['default_value'] = $value;
    return $this;
  }

  function setInstructions($desc) {
    $this->field['instructions'] = $desc;
    return $this;
  }

   protected function setKey($key) {
    $key = $this->prefix . $key;
    $this->key = $key;
    $this->field['key'] = $key;
    return $this;
  }

  function setName($name) {
    $this->name = strtolower($name);
    $this->field['name']  = $name;
    $this->field['_name'] = $name;
    $this->setPrefix();
    $this->setKey($name);
    return $this;
  }

  function set_Name() {
    $this->field['_name'] = '_' . $this->getName();
  }

  function setLabel($label=null) {
    if (!$label) {$label = $this->name;}
    $label = ucwords(str_replace('_',' ',$label));
    $this->field['label'] = $label;
    return $this;
  }

  function setType($type) {
    $this->field['type'] = strtolower($type);
    return $this;
  }

  function setRequired($required=1) {
    if ($required) {$this->field['required'] = $required;}
    elseif ($required == null) {unset($this->field['required']);}
    return $this;
  }

  function setWidth($width) {
    $this->field['wrapper']['width'] = $width;
    return $this;
  }

  function getField() {
    if ($this->logic) {
      $this->field['conditional_logic'] = $this->logic->getConditions();
    }
    if ($this->field['name'] == 'headline') {
      //diedump($this->field['key']);
    }
    return $this->field;
  }

  function inputError($expects,$given=null) {
    wp_die(__FUNCTION__ . ' expects ' . $expects . '.');
  }

}
