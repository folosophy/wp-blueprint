<?php

// TODO: extend bp autoloader class

function bp_theme_autoloader($class) {

  if (strpos($class,'Theme') !== 0) {return false;}
  $class = str_replace('Theme\\','',$class);
  $file  = strtolower(str_replace('\\','-',$class));
  $file  = str_replace('_','-',$file);
  $file  = array_unique(explode('-',$file));
  $file  = implode('-',$file);
  $file  = get_template_directory() . '/inc/' . $file;
  $file .= '.php';
  require $file;

} spl_autoload_register('bp_theme_autoloader');
