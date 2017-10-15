<?php

namespace Blueprint\Part;

class Intro {

  function __construct() {
    $active = get_field('intro_active');
    if ($active) {$this->setContent();}
  }

  protected function setContent() {
    $options = get_field('intro_options');
    
  }

}
