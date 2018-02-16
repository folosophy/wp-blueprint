<?php

namespace Blueprint;

class Config {

  protected $excerptLength;

  function __construct() {

  }

  function setExcerptLength($length) {
    if (!$length) {$length = 120;}
  }

  function getExcerptLength() {
    return $this->excerptLength;
  }

}
