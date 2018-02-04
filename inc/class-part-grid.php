<?php

namespace Blueprint\Part;

class Grid extends Part {

  protected $items;
  protected $colClass = 'col-3';
  protected $cols = 3;
  protected $numItems = 3;
  protected $type;
  protected $grid;

  protected function init() {
    $this->setClass('grid-container');
    $this->setType($this->name);
  }

  function getGrid() {
    return $this->initPart('grid');
  }

  function addItem($item) {
    // TODO: convert to part array?
    $this->items .= $item;
    return $this;
  }

  function setCols($num=3) {
    if (!$num || !is_int($num)) {$num = 3;}
    $this->cols = $num;
    $this->colClass = 'col-' . $num;
    return $this;
  }

  function setGrid() {
    $this->grid = (new Part())
      ->setClass('grid');
  }

  function setType($type=null) {
    if (!$type) {$type = 'post';}
    $this->type = $type;
  }

  function prepareGrid() {
    $grid = $this->getGrid()->insertPart($this->items);
    if ($this->type) {$grid->addClass('grid-' . $this->type);}
    $this->insertPart($this->getGrid());
  }

  function build() {
    $this->prepareGrid();
    return parent::build();
  }

}
