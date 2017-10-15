<?php

namespace Blueprint\Part;

class SectionHalves extends Section {

  private $field;
  private $headline;
  private $image;
  private $copy;
  private $wrapClass;

  function __construct($name) {
    parent::__construct($name);
    $this->setField($name);
  }

  private function setField($name) {
    $field = get_field($name);
    $this->field = $field;
    $this->setHeadline();
    $this->setImage();
    $this->setcopy();
  }

  private function setHeadline() {
    $this->headline = $this->field['headline'];
  }

  private function setImage() {
    $this->image = bp_get_img('img-bg','medium',$this->field['image']);
  }

  private function setcopy() {
    $this->copy = $this->field['copy'];
  }

  function addWrapClass($class='') {
    $this->wrapClass = $class;
    return $this;
  }

  function build() {
    return "
      <section id='$this->id' class='$this->class'>
        <div class='wrap-main $this->wrapClass'>
          <div class='grid-flex'>
            <div class='col-2'>
              <h1>$this->headline</h1>
              <p>$this->copy</p>
            </div>
            <div class='col-2'>
              <div class='container-showcase'>
                $this->image
              </div>
            </div>
          </div>
        </div>
      </section>
    ";
  }

}
