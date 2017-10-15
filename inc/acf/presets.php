<?php

namespace Blueprint;

class FieldBuilder {

  private $name;
  private $key;
  private $label;

  public function __construct($name) {
    $this->name = $name;
    $this->build();
  }

  public function build() {

  }

}
