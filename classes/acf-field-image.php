<?php

namespace Blueprint\Acf\Field;
use \Blueprint\Acf as acf;

class Image extends acf\Field {

  function init() {
    $this->setType('image');
    $this
      ->setReturnFormat('id')
      ->setLibrary('post');
  }

  function setReturnFormat($format='image') {
    $this->field['return_format'] = $format;
    return $this;
  }

  function setLibrary($library='post') {
    switch ($library) {
      case 'post' : $library = 'uploadedTo'; break;
      case 'all'  : $library = 'all'; break;
      default     : $library = 'uploadedTo';
    }
    $this->field['library'] = $library;
    return $this;
  }

  function setMinFileSize($size='1mb') {
    $this->field['min_size'] = $size;
    return $this;
  }

  function setFileType($type) {
    $type = func_get_args();
    $type = implode(',',$type);
    $this->field['mime_types'] = $type;
    return $this;
  }

}
