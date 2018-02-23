<?php

namespace Blueprint\Part;

class ListElement extends Part {

  function init() {
    $this->setTag('ul');
  }

  function addItem($text) {
    $item = $this->addPart()
      ->setTag('li');
    if (is_object($text)) {
      $item->addPart($text);
    } else {
      $item->addHtml($text);
    }
    return $this;
  }

  function buildInit() {
    $this->addClass('list');
  }

}
