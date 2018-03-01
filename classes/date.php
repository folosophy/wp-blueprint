<?php

namespace Blueprint;

class Date {

  protected $stamp;

  function __construct($string) {
    $stamp = strtotime($string);
    $stamp = date('Y',$stamp);
    diedump($stamp);
  }

}
