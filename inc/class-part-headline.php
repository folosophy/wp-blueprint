<?php

namespace Blueprint\Part;

class Headline extends Part {

  protected $headline;

  function init() {
    $this->setTag('h2');
  }

  function setHeadline($headline) {
    // TODO: Conditional lorem ipsum when testing mode is on
    if (!$headline) {
      if ($this->field) {$headline = $this->field['headline'];}
      elseif (is_string($this->field)) {$headline = $this->field;}
      else {$headline = 'Pellentesque habitant morbi tristique senectus';}
    }
    $this->headline = $headline;
    return $this;
  }

  function buildInit() {
    $this->part = $this->headline;
  }

}
