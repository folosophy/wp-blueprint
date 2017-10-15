<?php

namespace Blueprint\Media;

trait Builder {

  function addVideo($chain=false) {
    $field = $this->fieldGroup['video'];
    $part = (new Video($field));
    $this->addPart($part);
    return $this;
  }

}
