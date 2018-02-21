<?php

namespace Blueprint\Part;

class ListElement extends Part {

  function init() {
    $this->setTag('ul');
  }

  function addItem($text) {
    $this->addPart()
      ->setTag('li')
      ->addHtml($text);
    return $this;
  }

  function buildInit() {
    $this->addClass('list');
  }

}
