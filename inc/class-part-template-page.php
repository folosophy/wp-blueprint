<?php

namespace Blueprint\Part\Template;
use \Blueprint as bp;
use \Blueprint\Part as Part;
use \Blueprint\Part\Template as Template;

class Page extends Template {

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
