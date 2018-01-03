<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;
use \Blueprint as bp;

class Page extends bp\Template {

  protected $hero;
  protected $intro;

  protected function init() {
    parent::init();
  }

  function setIntro($name='intro',$chain=false) {
    $intro = (new part\Section('intro'))
      ->setClass('center');

    $wrap = $intro
      ->addWrap('blog')
        ->addClass('center intro')
        ->addHeadline()
        ->addCopy();

    $button = get_field('intro_button');

    if ($button) {
      $wrap->addButton()
        ->setType('primary')
        ->setField($button);
    }

    $this->intro = $intro;
    if ($chain) {return $this->intro;}
    else {return $this;}
  }

  function buildBody() {
    parent::buildBody();
    $this->body->insertPartAfter($this->intro,'hero');
  }

}
