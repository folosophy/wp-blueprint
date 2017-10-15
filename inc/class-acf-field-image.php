<?php

namespace Blueprint\Acf\Field;
use \Blueprint\Acf as acf;

class Image extends acf\Field {

  function init() {
    $this->setType('image');
    $this
      ->setReturnFormat('id')
      ->setLibrary();
  }

  function setReturnFormat($format='image') {
    $this->field['return_format'] = $format;
    return $this;
  }

  function setLibrary($library='post') {
    if ($library == 'post') {$library = 'uploadedTo';}
    else {$library = 'all';}
    $this->field['library'] = $library;
    return $this;
  }

  function setMinFileSize($size='1mb') {
    $this->field['min_size'] = $size;
    return $this;
  }

}
