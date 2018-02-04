<?php

namespace Blueprint\Acf\Field;
use \Blueprint\Acf as acf;

class Wysiwyg extends acf\Field  {

  function init() {
    $this->setType('wysiwyg');
    $this->setMedia(false);
    $this->setTabs();
    $this->setToolbar();
  }

  function setTabs($type='visual') {
    $choices = array('all','visual','text');
    if (in_array($type,$choices)) {
      $this->fields['tabs'] = $type;
    } else {wp_die("Wysiwyg: invalid tabs type.");}
    return $this;
  }

  function setToolbar($type='basic') {
    $choices = array('full','basic');
    if (in_array($type,$choices)) {
      $this->fields['toolbar'] = $type;
    } else {wp_die("Wysiwyg: invalid toolbar type.");}
    return $this;
  }

  function setMedia($upload=false) {
    if ($upload) {$this->field['media_upload'] = 1;}
    else {$this->field['media_upload'] = 0;}
    return $this;
  }

}
