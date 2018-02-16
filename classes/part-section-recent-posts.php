<?php

namespace Blueprint\Part\Section;
use Blueprint\Part as Part;

class RecentPosts extends Part\Section {

  protected $postType = 'post';
  protected $grid;

  function init() {
    $this->grid = new Part\PostGrid();
  }

  function getGrid() {
    $this->grid->parentChain = $this;
    return $this->grid;
  }

  function setDescription() {

  }

  function build() {
    $this->addHtml($this->grid->build());
    return parent::build();
  }

}
