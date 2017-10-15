<?php

namespace Blueprint;

class MainPages {

  protected $pages;

  function __construct($pages,$type='post') {
    $this->set($pages,$type);
  }

  function set($pages) {
    $tag = 'bp_main_pages';
    $this->pages = $pages;
    add_filter($tag,array($this,'addFilter'));
  }

  function addFilter($pages) {
    $pages = $this->pages;
    return $pages;
  }

}
