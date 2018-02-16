<?php

namespace Blueprint\Acf;

trait Builder {

  public $currentField;

  function setTitle($title=null) {
    if (!$title) {$title = $this->name;}
    $title = str_replace('_',' ',$title);
    $this->group['title'] = ucwords($title);
    return $this;
  }

  function setCurrentField($obj) {
    $this->currentField = $obj;
  }

  protected function setGroupKey() {
    $this->groupKey   = 'group_' . $groupName;
    $this->groupTitle = ucwords($this->groupKey);
  }

  public function setGroupTitle($name) {
    $this->groupTitle = ucwords($name);
  }

}
