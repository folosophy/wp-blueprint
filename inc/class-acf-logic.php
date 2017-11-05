<?php

namespace Blueprint\Acf;
use \Blueprint as bp;

class Logic {

  use bp\Chain;

  protected $conditions = array();
  protected $prefix = '';

  function __construct($parent) {
    $this->parent = $parent;
    $this->prefix = $parent->getPrefix();
  }

  function addCondition($field,$value,$operator='==') {
    $field = 'field_' . str_replace('field_','',$field);
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
