<?php

namespace Blueprint\Acf\Field;

class IconSelect extends Select {

  function init() {
    parent::init();
  }

  function setGlob($glob) {
    $glob = get_template_directory() . '/assets/img/icon-' . $glob;
    $glob = glob($glob);
    foreach ($glob as $file) {
      $start = strpos($file,'icon-');
      $file = substr($file,$start);
      $file = str_replace('icon-','',$file);
      $ext  = strpos($file,'.');
      $file = substr($file,0,$ext);
      $name = str_replace('-',' ',$file);
      $name = ucwords($name);
      $this->field['choices'][$file] = $name;
    }
  }

}
