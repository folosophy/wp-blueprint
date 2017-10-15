<?php

namespace Blueprint\Part;

class Index {

  private $header;
  protected $body;
  protected $footer;

  function __construct($context=null) {
    //$this->setHeader();
    $this->setHead();
  }

  private function setHeader() {
    $this->header = new Header();
  }

  private function setHead() {
    $this->head = new Head();
  }

  private function renderBody() {
    return function() {
      if (have_posts()) :
        while (have_posts()) :
          $this->body;
        endwhile;
      endif;
    };
  }

  function render() {
    $this->head->render();
  }

}
