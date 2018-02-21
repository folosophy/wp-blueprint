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

  function addLocation($param,$val=null,$operator='==') {

    // If only 1 argument
    if (!$val) {
      $val = $param;
      if (is_int($val)) {$param = 'page';}
      elseif (is_string($val)) {$param = 'post_type';}
    }

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

    return $this;

  }

  function setLocations() {
    $this->locations = array(func_get_args());
  }

  function getLocation() {
    return $this->location;
  }

}
