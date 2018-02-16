<?php

namespace Blueprint\Acf;

class Select_Theme_File {

  function setGlob($glob) {
    $glob = get_template_directory() . '/' . $glob;
    foreach ($glob as $file) {
      $key = basename($file);
      $val = $file;
      $this->field['choices'][$key] = $val;
    }
  }

}
