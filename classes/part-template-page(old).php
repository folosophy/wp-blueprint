<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;

class Page extends Template {

  protected $hero;
  protected $intro;

  function init() {
    parent::init();
  }

  function setHero($name=null,$chain=false) {
    wp_reset_query();
    $hero = (new part\Hero($name,$this));
    $this->hero = $hero;
    if ($chain) {return $hero;}
    else {return $this;}
  }

  function setIntro($name='',$chain=false) {
    $intro = (new part\Section('intro'))
      ->setClass('center')
      ->addWrap('blog')
        ->addClass('center intro')
        ->addHeadline()
        ->addCopy()
        ->end();
    return $this->addPart($intro,$chain);
  }

  function buildInit() {
    parent::buildInit();
    if (!$this->hero) {$this->setHero('secondary');}
    $this->prependPart($this->hero);
  }

}
