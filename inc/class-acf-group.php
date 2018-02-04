<?php

namespace Blueprint\Acf;
use \Blueprint as bp;

class Group {

  use Builder;
  use bp\Chain;
  use FieldBuilder;

  protected $fields = array();
  protected $name;
  private $groupLabel;
  protected $group = array();
  protected $location;
  protected $groupName;
  public $groupTitle;
  protected $prefix;
  protected $isGroup = true;
  protected $frunk;

  function __construct($name,$parent=null) {
    $this->setName($name);
    if ($this->name == 'dame_info') {$this->frunk = true;}
    $this->setTitle();
    $this->group['active'] = 1;
    $this
      ->setLabelPlacement('left')
      ->setOrder('middle');
      //setPosition('low');
    if ($parent) {$this->setParent($parent);}
    add_action('init',array($this,'register'));
  }

  function addFlexibleContent($name) {
    $field = (new Field\FlexibleContent($name,$this));
    return $this->addField($field,true);
  }

  function getLocation() {
    if (!isset($this->location)) {$this->setLocation();}
    return $this->location;
  }

  function setLabelPlacement($placement) {
    $placements = array('left','top');
    // TODO: class for errors
    if (!in_array($placement,$placements)) {wp_die('Invalid placement in: ' . __FUNCTION__ . " in " . __FILE__ . " at " . __LINE__);}
    if (property_exists($this,'group')) {$this->group['label_placement'] = $placement;}
    else {$this->field['label_placement'] = $placement;}
    return $this;
  }

  function setLocation($val=null,$param='post_type',$operator='==',$chain=false) {
    // Check if specific to certain page or post
    $vals  = array('front_page');
    $params = array('page','post','page_type','options_page');
    if ($val == 'front_page') {
      $param = 'page_type';
      // TODO: other specifics
    }
    //
    if (is_string($val)) {
      $val = array($val);
    }
    $location = (new Location($this));
    if ($val) {$location->addLocation($val,$param,$operator);}
    $this->location = $location;
    if ($chain) {return $location;}
    else {return $this;}
  }

  function setOrder($order,$place=null) {
    // TODO: Group Collection that sets order and numeric place within order set
    if (is_string($order)) {
      switch ($order) {
        case 'top'    : $order = 0; break;
        case 'high'   : $order = 10; break;
        case 'middle' : $order = 20; break;
        case 'low'    : $order = 30; break;
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

  function setStyle($style='default') {
    $options = array('default','seamless');
    if (!in_array($style,$options)) {$style = 'default';}
    $this->group['style'] = $style;
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

  function dumpFields() {
    var_dump($this->fields);
    return $this;
  }

  function dumpGroup() {
    diedump($this->group);
  }

  function register() {
    // Hide labels for single-field groups
    if (count($this->fields) == 1) {
      $this->fields[0]->addClass('nolabel group_only_one_field');
    }
    if (method_exists($this,'preRegister')) {
      $this->preRegister();
    }
    if ($this->location) {
      $this->group['location'] = $this->location->getLocation();
    }
    $this->group['fields'] = array();
    foreach ($this->fields as $field) {
      global $post;
      $field->applyLoadFilters();
      if (is_object($field)) {$field = $field->getField();}
      array_push($this->group['fields'],$field);
    }
    // if ($this->name == 'hero') {diedump($this->group);}
    acf_add_local_field_group(
      $this->group
    );
  }

}
