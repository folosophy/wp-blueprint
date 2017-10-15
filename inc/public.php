<?php

function bp_public_includes() {

  if (!is_admin()) {
    bp_glob_require('inc/public/render-',BP_PATH);
  }

} add_action('init','bp_public_includes');


function bp_autoloader($class) {

  if (strpos($class,'Blueprint') !== 0) {return false;}
  $class = explode('\\',strtolower($class));
  $path = BP_PATH . '/';
  $file = array_pop($class);
  switch ($class[1]) {
    case 'parts' : $path .= 'parts/' . $file; break;
  }
  $path .= '.php';
  include_once $path;

} spl_autoload_register('bp_autoloader');
