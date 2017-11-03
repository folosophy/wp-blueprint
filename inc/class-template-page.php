<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;

class Page extends Template {

  protected $hero;

  function setHero($type,$chain=false) {
    $hero = (new part\Hero($type,$this))
      ->setType($type);
    return $this->addPart($hero,$chain);
  }

}
