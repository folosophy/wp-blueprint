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
  protected $logic;
  protected $prefix;

  function __construct($key,$parentInstance) {
    $this->parentInstance = $parentInstance;
    $this->setName($key);
    $this->setKey($key);
    $this->setLabel();
    if (method_exists($this,'init')) {$this->init();}
    $this->setPrefix();
  }

  function getKey() {
    return $this->field['key'];
  }

  function getName() {
    return $this->field['name'];
  }

  function getParentKey() {
    return $this->parentInstance->getKey();
  }

  function getType() {
    return $this->field['type'];
  }

  function setLogic($key=null,$value=null,$operator='==') {
    $logic = (new acf\Logic($this));
    $this->logic = $logic;
    if ($key && $value) {
      $logic->addCondition($key,$value,$operator);
      return $this;
    } else {
      return $logic;
    }
  }

  protected function setPrefix() {
    $parent = $this->parentInstance;
    if (is_subclass_of($parent,'Blueprint\Acf\Field')) {
      $this->field['key'] = $parent->getKey() . '_' . $this->name;
    }
  }

  function setClass($class) {
    $this->field['wrapper']['class'] = $class;
    return $this;
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
    $this->field['key'] = 'field_' . $this->prefix . $key;
    return $this;
  }

  function setName($name) {
    $this->name = strtolower($name);
    $this->field['name']  = $name;
    $this->field['_name'] = $name;
    $this->setKey($name);
    $this->setPrefix();
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
    $this->field['required'] = $required;
    return $this;
  }

  function getField() {
    if ($this->logic) {
      $this->field['conditional_logic'] = $this->logic->getConditions();
    }
    return $this->field;
  }

  function inputError($expects,$given=null) {
    wp_die(__FUNCTION__ . ' expects ' . $expects . '.');
  }

}
