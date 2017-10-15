<?php

namespace Blueprint\Acf\Group;
use \Blueprint\Acf as acf;
use \Blueprint\Acf\Field as field;

class PostMedia extends acf\Group {

  protected $formats;

  function init() {
    $this->setName($this->name . '_post_media');
  }

  static function getDefaultFormats() {
    return array(
      'image',
      'video'
    );
  }

// Set default fields

protected function setDefaultFields() {
  foreach ($this->formats as $format) {
    if (in_array($format,self::getDefaultFormats())) {
      $method = 'set' . ucwords($format) . 'Field';
      $this->$method();
    }
  }
}

function setFormats($formats) {
  if (is_string($formats)) {$formats = array($formats);}
  $this->formats = $formats;
  return $this;
}

}
