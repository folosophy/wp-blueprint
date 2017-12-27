<?php

namespace Blueprint\Part;

class Headline extends Part {

  protected $inner;

  use HeadlineMethods;

  static function getTypes() {
    return array(
      'primary'
    );
  }

  function init() {
    $this->setTag('h2');
  }

  function getInner() {
    if (!$this->inner) {$this->inner = (new HeadlineInner());}
    if ($this->name) {
      $this->inner->setHeadline($this->name);
    }
    return $this->inner;
  }

  function setType($type) {
    $class = 'headline-' . $type;
    $this->setClass($class);
    $this->getInner()
      ->setClass($class . '__inner');
    return $this;
  }

  function buildInit() {
    if ($this->inner) {
      $this->insertPartAfter($this->getInner());
    } else {
      if (!$this->headline) {$this->setHeadline();}
      $this->addHtml($this->headline);
    }
  }

}

class HeadlineInner extends Part {

  use HeadlineMethods;

  function init() {
    $this->setTag('span');
  }

  function buildInit() {
    if (!$this->headline) {$this->setHeadline();}
    $this->addHtml($this->headline);
  }

}

trait HeadlineMethods {

  protected $headline;

  function setHeadline($headline=null) {
    if (!$this->headline) {
      if (!empty($this->field['headline'])) {$headline = $this->field['headline'];}
      elseif (is_string($this->field)) {$headline = $this->field;}
      elseif ($this->name) {$headline = $this->name;}
      else {$headline = 'Pellentesque habitant morbi.';}
    }
    $this->headline = $headline;
    return $this;
  }

}
