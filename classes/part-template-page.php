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
      ->setTheme('trans')
      ->addClass('center');

    $wrap = $intro
      ->addContainer('blog')
        ->addClass('center intro')
        ->addh2(get_field('intro_headline'))
        ->addCopy(get_field('intro_copy'),true)
          ->end();

    $button = get_field('intro_button');

    if (!empty($button['label'])) {
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
