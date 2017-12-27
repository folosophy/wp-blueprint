<?php

namespace Blueprint\Part\Template;
use \Blueprint\Part as part;

class Page extends Page {

  protected $hero;

  function init() {
    parent::init();
    $this->setHero()
  }

}
