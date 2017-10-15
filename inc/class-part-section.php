<?php

namespace Blueprint\Part;

class Section extends Part {

  protected $body;
  protected $id='';
  protected $name;
  protected $headline;
  protected $wrap;

  protected function init() {
    $this->setId();
    $this->setFieldGroup();
    $this->setWrap();
    $this->setAlign();
  }

  function setBody($body=null) {
    $this->body = $body;
    return $this;
  }

  function setId($id=null) {
    if (!$id) {$id = 'section-' . $this->name;}
    $this->id .= $id;
  }

  function setWrap($wrap='main') {
    $this->wrap = 'wrap-' . $wrap;
    return $this;
  }

  function build() {
    $body = $this->buildParts();
    return "
      <section id='$this->id' class='$this->class'>
        <div class='$this->wrap'>
          $body
        </div>
      </section>
    ";
  }

}
