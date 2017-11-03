<?php

namespace Blueprint\Part;

class Head  {

  private $wpHead;
  protected $bodyClass;
  private $charset;
  public $build;

  function __construct() {
    $this->setBodyType();
    $this->setInfo();
    $this->setWpHead();
    $this->setHead();
  }

  function setBodyType() {
    if (is_single()) {$type = 'single';}
    elseif (is_page()) {$type = 'page';}
    $this->bodyClass .= ' body-' . $type;
    return $this;
  }

  private function setInfo() {
    $this->siteName = get_bloginfo('name');
    $this->pageTitle = get_the_title();
    $this->charset = get_bloginfo('charset');
  }

  private function setWpHead() {
    ob_start();
    wp_head();
    $this->wpHead = ob_get_clean();
  }

  private function setHead() {
    $this->build = "
      <!DOCTYPE html>
      <html>
        <head>
          <meta charset='$this->charset'>
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
          <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
          <title>$this->siteName | $this->pageTitle</title>
          $this->wpHead
        </head>
        <body class='$this->bodyClass'>
    ";
  }

  public function render() {
    echo $this->build;
  }

}
