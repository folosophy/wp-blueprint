<?php

namespace Blueprint\Acf\Field;
use \Blueprint\Acf as acf;

class File extends acf\Field {

  function init() {
    $this->setType('file');
  }

  function setReturnFormat($format='id') {
    $choices = array('array','url','id');
    if (!in_array($choices,$format)) {$format = 'id';}
    $this->field['return_format'] = $format;
    return $this;
  }

  function setLibrary($library) {
    $choices = array('all','post');
    if (!in_array($choices,$library)) {$library = 'all';}
    if ($library == 'post') {$library = 'uploadedTo';}
    $this->field['library'] = $library;
    return $this;
  }

  function setMaxSize($size) {
    $this->field['max_size'] = $size;
    return $this;
  }

  function setMinSize($size) {
    $this->field['min_size'] = $size;
    return $this;
  }

  function setFileType($type) {
    diedump('need to finish field file setFileType');
  }

}
