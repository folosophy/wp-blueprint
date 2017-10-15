<?php

namespace Blueprint;

class Enqueue {

  protected $actions;
  protected $name;
  protected $dependencies;
  protected $dir;
  protected $footer;
  protected $plugin;
  protected $src;
  protected $type;
  protected $version;

  // TODO: multiple actions? automatically enqueue

  function __construct($name,$path=null,$plugin=false) {
    $this->name = $name;
    $this->action = 'wp_enqueue_scripts';
    if (method_exists($this,'setType')) {
      $this->setType();
    }
    if ($path) {
      $this->setDir($plugin);
      $this->setSrc($path);
      $this->setVersion();
      $this->setDependencies();
    }
  }

  function addAction($action=null) {
    if (!$action) {$action = 'wp_enqueue_scripts';}
    add_action($action,array($this,'enqueue'));
  }

  function setAction() {
    if (!$action) {$action = 'wp_enqueue_scripts';}
    add_action($action,array($this,'enqueue'));
  }

  function setDependencies($deps=null) {
    $this->dependencies = $deps;
  }

  protected function setDir($plugin) {
    if ($plugin) {$dir = 'plugins/' . $plugin;}
    else {$dir = 'themes/' . get_template();}
    $this->dir = 'wp-content/' . $dir;
  }

  protected function setSrc($path) {
    $src = $this->dir . '/' . $path;
    $this->path = ABSPATH . $src;
    $this->src  = '/' . $src;
  }

  protected function setVersion($ver=null) {
    if (!$ver) {$ver = filemtime($this->path);}
    $this->version = $ver;
  }

}
