<?php

namespace Blueprint\Acf\Field;
use \Blueprint as bp;
use \Blueprint\Acf as acf;

class Group extends acf\Field {

  use acf\FieldBuilder;

  public $isGroupField = true;
  protected $fields = array();

  function init() {
    $this->setType('group');
    if (is_object($this->parent) && get_parent_class($this->parent) == "Blueprint\\Acf\\Field") {
      $this->setLayout('block');
    } else {
      $this->setLayout('row');
    }
    $this->addPrefix();
  }

  function addPrefix() {
    $this->prefix .= $this->name . '_';
  }

  function getField() {
    $this->field['sub_fields'] = array();
    foreach ($this->fields as $field) {
      $field = $field->getField();
      array_push($this->field['sub_fields'],$field);
    }
    $field = parent::getField();
    $field['sub_fields'] = $this->field['sub_fields'];
    return $field;
  }

  function endGroup() {
    return $this->end();
  }

  function getFields() {
    return $this->fields;
  }

}
