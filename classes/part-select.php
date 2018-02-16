<?php

namespace Blueprint\Part;

class Select extends Part {

  protected $options = array();

  function addOption($key,$val) {
    $options[$key] = $val;
  }

  function getOptions() {
    $options;
    foreach ($this->options as $key => $val) {
      $title =
      $options .= "<option value='$key'>$val</option>";
    }
    return $options;
  }

}
