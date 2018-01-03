<?php

namespace Blueprint;
use \Blueprint\Part as part;

class Template extends part\Part {

  protected $head;
  protected $header;
  protected $body;
  protected $hero;
  protected $intro;
  protected $postType;

  protected function init() {
    wp_reset_query();
    $this->postType = get_post_type();
    $this->setTag('body');
    $this->setTemplateType();
  }

  function setTemplateType() {
    global $post;
    if (is_single())   {$class = 'single_' . get_post_type();}
    elseif (is_page()) {
      $class  = 'page-' . $post->post_name;
      $class .= ' body-page';
    }
    $this->addClass($class);
  }

  function getBody() {
    if (!isset($this->body)) {
      $this->setBody();
    }
    return $this->body;
  }

  function getHeader() {
    if (!isset($this->header)) {
      $this->header = bp_get_part('header');
    }
    return $this->header;
  }

  function getHero() {
    if (!isset($this->hero)) {$this->setHero();}
    return $this->hero;
  }

  function setBody() {
    $this->body = (new part\Part())
      ->setTag('body');
    return $this->body;
  }

  protected function setHead() {
    $this->head = new part\Head();
  }

  function setHero() {
    $this->hero = (new part\Hero());
    return $this;
  }

  protected function setPropPart($prop='parts') {
    $this->propPart = $prop;
    return $this;
  }

  protected function getFooter() {
    ob_start();
    get_template_part('parts/footer');
    $footer = ob_get_clean();
    $footer .= "
      </body>
      </html>
    ";
    return $footer;
  }

  protected function getPart($base,$part) {
    ob_start();
    get_template_part("parts/$base",$part);
    return ob_get_clean();
  }

  // Deprecated
  protected function getTemplate($base,$part) {
    ob_start();
    get_template_part("parts/$base",$part);
    return ob_get_clean();
  }

  function setBodyType() {
    if (is_single()) {
      $this->addClass();
    }
    elseif (is_page()) {
      $this->bodyClass .= 'page-' . $this->post->post_name;
      $type = 'page';
    }
    else {$type = 'index';}
    $this->bodyClass .= ' body-' . $type;
    return $this;
  }

  function buildBody() {
    if (!isset($this->body)) {$this->setBody();}
    $this->addPart($this->body);
    if (!$this->head) {$this->setHead();}
    $this->insertPartBefore($this->head);
    // Nav
    $nav = (new part\Part())
      ->setTag(false)
      ->setName('nav')
      ->addHtml($this->getHeader());
    $this->body->insertPartBefore($nav);
  }

  function buildFooter() {
    $this->getBody()->addHtml($this->getFooter());
  }

  protected function buildHero() {
    if (isset($this->hero)) {
      $this->getBody()->insertPartBefore($this->getHero());
    }
  }

  function build() {
    //$this->buildHeader();
    $this->buildHero();
    $this->buildBody();
    $this->buildFooter();
    return parent::build();
  }

  //
  // // TODO: build zones... children
  // function render() {
  //   parent::render();
  //   get_template_part('parts/footer');
  // }

}
