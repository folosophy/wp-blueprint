<?php

namespace Blueprint;

// https://codex.wordpress.org/Roles_and_Capabilities

class Role {

  protected $name;
  protected $capabilities;
  protected $clone;
  protected $label;

  function __construct($name) {
    $this->name = $name;
    add_action('init',array($this,'addRole'),999);
  }

  function addCapabilities($caps) {
    $this->getCapabilities();
    foreach ($caps as $key) {
      $this->setCapability($key,true);
    }
  }

  function removeCapabilities($caps) {
    $this->getCapabilities();
    foreach ($caps as $key) {
      $this->setCapability($key,false);
    }
  }

  function getCapabilities() {
    if (!isset($this->capabilities)) {
      $this->capabilities = array();
    }
    return $this->capabilities;
  }

  function getLabel() {
    if (!$this->label) {$this->setLabel();}
    return $this->label;
  }

  function setCapability($key,$val) {
    $this->getCapabilities();
    $val = (bool) $val;
    $this->capabilities[$key] = $val;
    return $this;
  }

  function setClone($role) {
    $this->clone = $role;
    add_action('init',array($this,'clone'));
    return $this;
  }

  function setLabel($label=null) {
    if (!$label) {$label = ucwords(str_replace('_',' ',$this->name));}
    $this->label = $label;
    return $this;
  }

  function clone() {
    global $wp_roles;
    $role = $wp_roles->get_role($this->clone);
    $caps = $role->capabilities;
    $this->capabilities = array_merge($caps,$this->getCapabilities());
  }

  function addRole() {
    // TODO: only remove and add if there are changes
    remove_role($this->name);
    add_role($this->name,$this->getLabel(),$this->capabilities);
  }

}
