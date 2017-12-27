<?php

namespace Blueprint\Part;

class Copy extends Part {

  protected $copy;

  function init() {
    $this->setTag('p');
  }

  function setCopy($copy=null) {
    // TODO: Conditional lorem ipsum when testing mode is on
    if (!$copy) {
      if (!empty($this->field['copy'])) {$copy = $this->field['copy'];}
      elseif (is_string($this->field)) {$copy = $this->field;}
      else {$copy = 'Nulla facilisi. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Pellentesque auctor neque nec urna. Morbi nec metus. Curabitur ullamcorper ultricies nisi.';}
    }
    $this->copy = $copy;
    return $this;
  }

  function setTag($tag='p') {
    $this->tag = $tag;
    return $this;
  }

  function buildInit() {
    if (!$this->copy) {$this->setCopy();}
    $this->part = $this->copy;
  }

}
