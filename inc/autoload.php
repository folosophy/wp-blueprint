<?php

namespace Blueprint;

// TODO: Rewrite as class

class Autoloader {

  protected $dump;
  protected $base;
  protected $namespace;
  protected $path;

  function __construct($namespace,$base=null) {
    $this->namespace = $namespace;
    if (!$base) {$this->base = get_template_directory();}
    else {$this->base = WP_PLUGIN_DIR . '/' . $base;}
    spl_autoload_register(array($this,'load'));
  }

  // Class Loader

  function load($class) {

    if (strpos($class,$this->namespace) !== 0) {return false;}

    $class = str_replace("$this->namespace\\",'',$class);
    $class  = array_unique(explode('\\',$class));
    $class  = implode('\\',$class);

    // Write path
    if (strpos($class,'\\') !== false) {
      $path  = explode('\\',$class,-1);
      $path  = implode('\\',$path) . '-';
      $path  = strtolower(str_replace('\\','-',$path));
    } else {
      $path = null;
    }

    $path = 'classes/' . $path;

    // Write name
    $name  = explode('\\',$class);
    $name  = end($name);
    $name  = str_replace('_','-',$name);
    $name  = preg_split('/(?=[A-Z])/',lcfirst($name));
    $name  = implode('-',$name);
    $name  = strtolower($name);

    $name .= '.php';

    // Write file
    $file = $this->base . '/' . $path . $name;

    require_once $file;

  }

}

$theme = new Autoloader('Theme');
$bp = new Autoloader('Blueprint',BP);
