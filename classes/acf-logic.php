<?php

namespace Blueprint\Acf;
use \Blueprint as bp;

class Logic {

  use bp\Chain;

  protected $conditions = array();
  protected $prefix;

  function __construct($parent) {
    $this->parent = $parent;
    $this->setPrefix(true);
  }

  // Whether to apply logic to group or global
  function setPrefix() {
    $this->prefix = $this->parent->getPrefix();
    // Setup prefix
    $s = strrpos($this->prefix,$this->parent->getName() . '_');
    if ($s) {$this->prefix = substr($this->prefix,0,$s);}
    return $this;
  }

  // NOTE: operator should be '==' or '!='

  function addCondition($field,$value,$operator='==') {
    if (is_bool($value)) {$value = (int) $value;}
    $field = str_replace('field_','',$field);
    if ($this->prefix) {$field = $this->prefix . $field;}
    else {$field = 'field_' . $field;}
    array_push(
      $this->conditions,
      array(
        array(
          'field' => $field,
          'value' => $value,
          'operator' => $operator
        )
      )
    );
    return $this;
  }

  function andCondition($field,$value,$operator='==') {
    if (is_bool($value)) {$value = (int) $value;}
    $field = 'field_' . str_replace('field_','',$field);
    $index = count($this->conditions) - 1;
    array_push(
      $this->conditions[$index],
      array(
        'field' => $field,
        'value' => $value,
        'operator' => $operator
      )
    );
    return $this;
  }

  function endLogic() {
    return $this->end();
  }

  function getConditions() {
    return $this->conditions;
  }

}
