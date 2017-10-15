<?php

namespace Blueprint\Part;

class Part {

  protected $groupName;

  function __construct() {

  }

  protected function setGroupName($name) {
    $this->groupName = $name;
  }

  protected function getGroupField($field) {
    return get_field($this->groupName . '_' . $field);
  }

}
