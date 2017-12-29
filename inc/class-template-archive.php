<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;

class Archive extends Page {

  protected $archive;
  protected $archivePostType;
  protected $grid;
  protected $cols;

  function init() {
    parent::init();
    add_action('wp_enqueue_scripts',array($this,'localizeLoadMore'));
  }

  function getGrid() {
    if (!isset($this->grid)) {$this->setGrid();}
    return $this->grid;
  }

  function setGrid() {
    global $post;
    $this->grid = (new part\PostGrid())
      ->setArg('post_type',$post->post_name)
      ->setArg('numberposts',9);
  }

  function localizeLoadMore() {
    $query = $this->getGrid()->getQuery();
    wp_localize_script('bp_lazy_loader_script','archive',array('query_vars'=>$query->query_vars));
  }

  function buildArchive() {
    $this->archive = (new part\Section('archive'))
      ->addWrap()
        ->insertPart($this->getGrid())
        ->end();
    $this->getBody()->insertPart($this->archive);
  }

  function buildBody() {
    parent::buildBody();
    $this->buildArchive();
  }

  // function init() {
  //   parent::init();
  //   // TODO: MT template-page and extend
  //   $this->buildGrid();
  // }
  //
  // function setCols($num) {
  //   if (!is_int($num)) {wp_die('Archive setCols expects int');}
  //   $this->grid->setCols($num);
  //   return $this;
  // }
  //
  // function buildGrid() {
  //   $post_type = $this->archivePostType ?: 'post';
  //   $grid = (new part\PostGrid())
  //     ->setPostType($post_type)
  //     ->setNumberPosts(12);
  //   $this->grid = $grid;
  //   $section = (new part\Section('posts'))
  //     ->addWrap('main')
  //       ->addPart($grid)
  //       ->end();
  //   $this->addPart($section);
  // }
  //
  // function setArchivePostType($type) {
  //   $this->grid->setPostType($type);
  //   return $this;
  // }

}
