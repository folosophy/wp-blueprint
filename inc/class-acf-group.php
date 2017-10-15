<?php

namespace Blueprint\Acf;
use \Blueprint as bp;

class Group {

  use Builder;
  use FieldBuilder;

  protected $fields = array();
  protected $name;
  private $groupLabel;
  protected $group = array();
  protected $location;
  protected $groupName;
  public $groupTitle;
  protected $prefix;

  function __construct($name,$parentInstance=null) {
    $this->setName($name);
    $this->setTitle();
    $this->group['active'] = 1;
    $this
      ->setLabelPlacement('left')
      ->setOrder('middle');
      //setPosition('low');
    if ($parentInstance) {$this->chainInit($parentInstance);}
    add_action('init',array($this,'register'));
  }

  function addRepeater($name) {
    $field = (new Field\Repeater($name,$this));
    return $this->addField($field,true);
  }

  function setLabelPlacement($placement) {
    $placements = array('left','top');
    // TODO: class for errors
    if (!in_array($placement,$placements)) {wp_die('Invalid placement in: ' . __FUNCTION__ . " in " . __FILE__ . " at " . __LINE__);}
    if (property_exists($this,'group')) {$this->group['label_placement'] = $placement;}
    else {$this->field['label_placement'] = $placement;}
    return $this;
  }

  function setLocation($val,$param='post_type',$operator='==',$chain=false) {
    // Check if specific to certain page or post
    $vals  = array('front_page');
    $params = array('page','post','page_type','options_page');
    if ($val == 'front_page') {
      $param = 'page_type';
      // TODO: other specifics
    }
    //
    if (is_string($val))
    $location = (new Location($this))
      ->addLocation($val,$param,$operator);
    $this->location = $location;
    if ($chain) {return $location;}
    else {return $this;}
  }

  function setOrder($order,$place=null) {
    // TODO: Group Collection that sets order and numeric place within order set
    if (is_string($order)) {
      switch ($order) {
        case 'high'   : $order = 1; break;
        case 'middle' : $order = 5; break;
        case 'low'    : $order = 10; break;
        case 'bottom' : $order = 99999; break;
        default: $order = 10;
      }
    }
    $this->group['menu_order'] = $order;
    return $this;
  }

  function setName($name) {
    // Set specific page and key
    if (strpos($name,'-')) {
      $name = explode('-',$name);
      $this->setPrefix($name[0]);
      $key = implode('_',$name);
      $name = $name[1];
    } else {$key = $name;}
    $this->name = strtolower($name);
    $this->group['name'] = $name;
    $this->group['key'] = 'group_' . $key;
    return $this;
  }

  protected function setPrefix($prefix) {
    $this->prefix = $prefix . '_';
  }

  function setPosition($position) {
    if ($position == 'high') {$position = 'acf_after_title';}
    $this->group['position'] = $position;
    return $this;
  }

  function getFields() {
    return $this->fields;
  }

  function getName() {
    return $this->name;
  }

  function hideGroup() {
    $this->group['hide_group'] = true;
    return $this;
  }

  function register() {
    if (method_exists($this,'preRegister')) {
      $this->preRegister();
    }
    $this->group['location'] = $this->location->getLocation();
    $this->group['fields'] = array();
    foreach ($this->fields as $field) {
      if (is_object($field)) {$field = $field->getField();}
      array_push($this->group['fields'],$field);
    }
    if ($this->name == 'about') {
      //diedump($this->group['name']);
    }
    acf_add_local_field_group(
      $this->group
    );
  }

}
