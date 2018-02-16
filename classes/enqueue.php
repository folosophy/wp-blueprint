<?php

namespace Blueprint\Enqueue;

class Enqueue {

  protected $actions;
  protected $name;
  protected $dependencies;
  protected $dir;
  protected $file;
  protected $fileFormat;
  protected $footer;
  protected $plugin;
  protected $src;
  protected $subDir;
  protected $type;
  protected $version;

  function __construct($name,$file,$plugin=false) {
    $this->file = $file;
    $this->name = $name;
    $this->plugin = $plugin;
    $this->action = 'wp_enqueue_scripts';
    if (method_exists($this,'setType')) {
      $this->setType();
    }
    $this->addAction();
  }

  function addAction($action=null) {
    if (!$action) {$action = 'wp_enqueue_scripts';}
    add_action($action,array($this,'enqueue'));
  }

  function setAction($action=null) {
    if (!$action) {$action = 'wp_enqueue_scripts';}
    add_action($action,array($this,'enqueue'));
  }

  function setDependencies($deps=null) {
    $this->dependencies = $deps;
  }

  protected function setDir() {
    if ($this->plugin) {$dir = 'plugins/' . $this->plugin;}
    else {$dir = 'themes/' . get_template();}
    $this->dir = 'wp-content/' . $dir;
  }

  protected function setSrc() {
    if ($this->subDir !== false) {$subDir = 'assets' . '/' . $this->type . '/';}
    else {$subDir = null;}
    $src = $this->dir . '/' . $subDir  . $this->file;
    $this->path = ABSPATH . $src;
    $this->src  = '/' . $src;
  }

  function setSubDir($dir) {
    $this->subDir = $dir;
    return $this;
  }

  protected function setVersion($ver=null) {
    if (!$ver) {$ver = filemtime($this->path);}
    $this->version = $ver;
  }

  protected function preEnqueue() {
    if ($this->file) {
      $this->setDir();
      $this->setSrc();
      $this->setVersion();
      $this->setDependencies();
    }
  }

  function enqueue() {
    $this->preEnqueue();
  }

}
