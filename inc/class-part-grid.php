<?php

namespace Blueprint\Part;

class Grid extends Part {

  protected $items;
  protected $colClass = 'col-3';
  protected $cols = 3;
  protected $numItems = 3;
  protected $type;
  protected $grid;
  public $parentChain;

  function endChain() {
    return $this->parentChain;
  }

  function addItem($item=null) {
    $this->items .= "
      <div class='$this->colClass'>
        $item
      </div>
    ";
    return $this;
  }

  function setCols($num=3) {
    if (!$num || !is_int($num)) {$num = 3;}
    $this->cols = $num;
    $this->colClass = 'col-' . $num;
    return $this;
  }

  function build() {
    return "
      <div class='grid'>
        $this->items
        hello
      </div>
    ";
  }

}
