<?php

namespace Blueprint\Acf\Field;
use \Blueprint\acf as acf;

class PostObject extends acf\Field {

  protected function init() {
    $this->field['type'] = 'post_object';
    $this->setReturnFormat();
    $this->setMultiple();
    $this->setPostType();
  }

  function allowNull($allow=false) {
    if (!is_bool($allow)) {$this->throwInputError('bool');}
    if ($allow == true) {
      $allow = 1;
      $this->field['allow_null'] = $allow;
    }
    return $this;
  }

  function setMultiple($multiple = 0) {
    $this->field['multiple'] = $multiple;
    return $this;
  }

  function setPostType($type=null) {
    if (is_string($type)) {$type = array($type);}
    if (!$type) {$type = array('post','page');}
    $this->field['post_type'] = $type;
    return $this;
  }

  function setReturnFormat($format = 'id') {
    $formats = array('object','id');
    if (!in_array($format,$formats)) {$this->throwInputError('object or id');}
    $this->field['return_format'] = $format;
    return $this;
  }

  function setTaxonomy() {
    $this->field['taxonomy'] = array();
    return $this;
  }

}
