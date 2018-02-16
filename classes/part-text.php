<?php

namespace Blueprint\Part;

class Text extends Part {

  protected $placeholder;
  protected $text;

  function init() {
    if ($this->name) {$this->setText($this->name);}
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

    if ($text) {

      if (strpos($text,'<p')) {

        $this->setTag('div');

        $this->text = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $text);

        // $text = str_replace('</p>','',$text);
        // $text = explode('<p>',$text);
        // $text = array_filter($text); // Remove empty p tags
        //
        // foreach ($text as $p) {
        //   diedump();
        //   $el = (new Text($p))
        //     ->addClass('multi')
        //     ->build();
        //   $this->text .= $el;
        //}

      } else {
        $this->text = $text;
      }

    } else {
      $this->text = $this->getPlaceholder();
    }

    return $this;

  }

  function buildInit() {
    $this->addHtml($this->getText());
  }

}
