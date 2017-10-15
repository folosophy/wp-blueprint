<?php

namespace Blueprint\Part;

class Body extends Part {

  protected $hero;

  function setHero($type,$chain=false) {
    $hero = (new Hero($type,$this))
      ->setType($type);
    $this->hero = $hero;
    return $this->chain($hero,$chain);
  }

  function preBuild() {
    if (!$this->hero) {
      $this->setHero();
    }
    $this->build .= $this->hero->build();
  }

  function build() {
    $this->preBuild();
    return $this->build;
  }

}
