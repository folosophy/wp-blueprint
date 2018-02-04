<?php

namespace Blueprint\Acf;
use \Blueprint as bp;

class Location {

  protected $location = array();
  protected $locationIndex = 0;

  function __construct($groupInstance) {
    $this->parentChain = $groupInstance;
  }

  use bp\Chain;

  function addLocation($vals,$param='post_type',$operator='==') {
    if (is_int($vals) && !$param) {$param = 'page';}
    if (!is_array($vals)) {$vals = array($vals);}
    foreach ($vals as $val) {
      array_push(
        $this->location,
        array(
          array(
            'param'    => $param,
            'operator' => $operator,
            'value'    => $val
          )
        )
      );
    }
    return $this;
  }

  function getLocation() {
    return $this->location;
  }

}
