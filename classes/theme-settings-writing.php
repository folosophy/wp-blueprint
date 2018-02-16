<?php

namespace Blueprint\Theme\Settings;

trait Writing {

  protected $postFormats;

  function getPostFormats() {
    if (!$this->postFormats) {$this->setPostFormats();}
  }

  function setPostFormats($formats=null) {
    foreach ($formats as $format) {
      $this->postFormats[$format] = ucwords($format);
    }
  }

}
