<?php

namespace Blueprint\Acf;
use \Blueprint as bp;
use \Blueprint\Acf as acf;

class Field {

  use Builder;
  use bp\Chain;

  protected $debugId;
  protected $name;
  protected $field = array();
  protected $hidden;
  protected $key;
  protected $logic;
  protected $prefix;
  protected $saveKeys;
  protected $saveValue;

  function __construct($key,$parent) {
    $this->parent = $parent;
    $this->setName($key);
    $this->setPrefix();
    $this->setLabel();
    $this->field['wrapper'] = array();
    $this->setRequired(true);
    if (method_exists($this,'init')) {$this->init();}
    add_action('bp/acf/filter_fields',array($this,'filter'));
  }

  function addSaveKey($key,$table=null) {

    if (!$table) {
      switch ($key) {
        case 'post_title'   : $table = 'wp_posts'; break;
        case 'post_content' : $table = 'wp_posts'; break;
      }
    }

    // Setup vars
    $save = array();
    if (!is_array($this->saveKeys)) {$this->saveKeys = array();}

    // Set table type
    $tables = array('wp_posts','wp_postmeta','wp_options','wp_users');
    if (!in_array($table,$tables)) {diedump('Field addSaveKey: invalid db table');}
    $save['table'] = $table;

    // Add key
    $save['key'] = $key;

    array_push($this->saveKeys,$save);

    add_filter("acf/update_value/key=$this->key",array($this,'saveValue'));

    return $this;

  }

  function applyLoadFilters() {
    $tag = 'bp/load_field/key=' . $this->key;
    apply_filters($tag,$this);
  }

  function setDisabled() {
    $this->field['disabled'] = true;
    $this->field['readonly'] = 1;
    return $this;
  }

  function dumpField() {
    diedump($this->field);
  }

  function getKey() {
    return $this->field['key'];
  }

  function getLogic() {
    if (!isset($this->logic)) {$this->setLogic();}
    return $this->logic;
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

  function setDebugId($id) {
    $this->debugId = $id;
    return $this;
  }

  function hideLabel() {
    $this->addClass('nolabel');
    return $this;
  }

  function setLogic($key=null,$value=null,$operator='==') {
    $logic = (new acf\Logic($this));
    $this->logic = $logic;
    if (isset($key)) {
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

  function saveValue($val) {

    if (is_array($this->saveKeys)) {
      foreach ($this->saveKeys as $save) {
        switch($save['table']) {
          case 'wp_postmeta' :
            $update = update_post_meta(get_the_ID(),$save['key'],$val);
            break;
          case 'wp_posts' :
            $update = wp_update_post(array(
              'ID' => get_the_ID(),
              $save['key'] => $val
            ));
            break;
        }
      }
    }
    return $val;

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
    return $this;
  }

  function filter() {
    apply_filters('bp/acf/field/' . $this->name,$this);
  }

  function setDefaultValue($value) {
    $this->field['default_value'] = $value;
    return $this;
  }

  function setHidden($bool) {
    $this->hidden = (bool) $bool;
    return $this;
  }

  function setInstructions($desc) {
    $this->field['instructions'] = $desc;
    return $this;
  }

  function setKey($key) {
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
    return $this;
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
    else {unset($this->field['required']);}
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
    if ($this->hidden) {
      $this->addClass('hidden');
    }
    return $this->field;
  }

  function inputError($expects,$given=null) {
    wp_die(__FUNCTION__ . ' expects ' . $expects . '.');
  }

}
