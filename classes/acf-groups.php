<?php

namespace Blueprint\Acf;

class Groups {

  private $fields = array();
  private $groupName;
  private $groupLabel;
  private $group = array();

  function __construct($groupName) {
    $this->setGroupInfo($groupName);
    add_action('admin_init',array($this,'register'));
  }

  private function setGroupInfo($name) {
    $this->setGroupName($name);
    $this->setGroupTitle($name);
    $this->group['fields'] = array();
    $this->group['location'] = array();
  }

  private function setGroupName($name) {
    $this->groupName = strtolower($name);
    $this->group['key']  = 'group_' . $name;
    $this->group['active'] = 1;
  }

  public function setGroupTitle($title=null) {
    if (!$title) {$title  = $this->name;}
    $this->group['title'] = ucwords($title);
  }

  function addLocation($location) {
    if (is_string($location)) {$location = array('post_type','=',$location);}
    $location = array(
        'param'    => $location[0],
        'operator' => $location[1],
        'value'    => $location[2]
    );
    array_push($this->group['location'],array($location));
    return $this;
  }

  function register() {
    acf_add_local_field_group(
      $this->group
    );
  }

}
