<?php

namespace Blueprint\Part;

class Text extends Part {

  protected $placeholder;
  protected $text;

  function init() {
    $this->setText($this->name);
    $this->setTag('p');
    $this->setLazy(true);
  }

  function getPlaceholder() {
    return $this->checkSet('placeholder');
  }

  function getText() {
    return $this->checkSet('text');
  }

  function setPlaceholder($text=null) {
    if (!$text) {$text = 'Donec sodales sagittis magna. Praesent egestas tristique nibh. Phasellus viverra nulla ut metus varius laoreet. Phasellus volutpat, metus eget egestas mollis.';}
    $this->placeholder = $text;
    return $this;
  }

  function setText($text=null) {
    if (!$text) {$text = $this->getPlaceholder();}
    else {
      // $text = str_replace('</p>','',$text);
      // $array = explode('<p>', $text);
    }
    $this->text = $text;
    return $this;
  }

  function buildInit() {
    $this->addHtml($this->getText());
    $this->setDebugId(1);
  }

}
