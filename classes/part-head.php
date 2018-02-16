<?php

namespace Blueprint\Part;

class Head extends Part  {

  private $wpHead;
  protected $bodyClass;
  private $charset;
  public $build;

  function init() {
    wp_reset_query();
    $this->setTag('head');
  }

  // function setBodyType() {
  //   if (is_single()) {$type = 'single';}
  //   elseif (is_page()) {
  //     $this->bodyClass .= 'page-' . $this->post->post_name;
  //     $type = 'page';
  //   }
  //   else {$type = 'index';}
  //   $this->bodyClass .= ' body-' . $type;
  //   return $this;
  // }

  private function setInfo() {
    $this->siteName = get_bloginfo('name');
    $this->pageTitle = get_the_title();
    $this->charset = get_bloginfo('charset');
  }

  private function getWpHead() {
    ob_start();
    wp_head();
    $this->wpHead = ob_get_clean();
    return $this->wpHead;
  }

  protected function getMeta() {
    $site_name = get_bloginfo('name');
    $title     = get_the_title();
    $this->meta = "
      <meta charset=''>
      <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
      <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
      <title> $site_name | $title</title>
    ";
    return $this->meta;
  }

  function buildInit() {
    $this->addHtml($this->getWpHead());
    $this->addHtml($this->getMeta());
  }

  function build() {
    echo "<!DOCTYPE html>";
    return parent::build();
  }

}
