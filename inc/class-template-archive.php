<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;

class Archive extends Template {

  protected $archivePostType;
  protected $grid;

  function init() {
    // TODO: MTFN
    $intro = (new part\Section('intro'))
      ->setClass('center collapse-bottom')
      ->addWrap('blog')
        ->addClass('center intro')
        ->addHeadline()
        ->addCopy()
        ->end();
    $this->addPart($intro);
    $this->buildGrid();
  }

  function buildGrid() {
    $post_type = $this->archivePostType ?: 'post';
    $grid = (new part\PostGrid())
      ->setPostType($post_type)
      ->setNumberPosts(12);
    $this->grid = $grid;
    $section = (new part\Section('posts'))
      ->addWrap('main')
        ->addPart($grid);
    $this->addPart($section);
  }

  function setHero($name,$chain=false) {
    $hero = (new part\Hero($name,$this))
      ->setParent($this)
      ->setType('secondary');
    $this->hero = $hero;
    if ($chain) {return $hero;}
    else {return $this;}
  }

  function setArchivePostType($type) {
    $this->grid->setPostType($type);
    return $this;
  }

}
