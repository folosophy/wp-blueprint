<?php

namespace Blueprint\Part;

class Template extends Part {

  protected $head;
  protected $header;
  protected $body;
  protected $hero;
  protected $intro;
  protected $postType;

  protected function init() {
    wp_reset_query();
    $this->postType = get_post_type();
    $this->setTag('html');
    $this->setAttr('lang','en');
    $this->setTemplateType();
  }

  function setTemplateType() {
    global $post;
    if (is_single())   {
      $this->addClass('single-' . get_post_type());
      $this->addClass('body-single');
    }
    elseif (is_page()) {
      $this->addClass('page-' . $post->post_name);
      $this->addClass('body-page');
    }
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
    $this->body = (new Part())
      ->setTag('body');
    return $this->body;
  }

  protected function setHead() {
    $this->head = new Head();
  }

  function setHero($name=null) {
    $this->hero = (new Hero($name));
    return $this->hero;
  }

  protected function setPropPart($prop='parts') {
    $this->propPart = $prop;
    return $this;
  }

  protected function getFooter() {
    return bp_get_part('footer');
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
    elseif (is_search()) {}
    else {$type = 'index';}
    $this->bodyClass .= ' body-' . $type;
    return $this;
  }

  function buildBody() {
    if (!isset($this->body)) {$this->setBody();}
    $this->addPart($this->body);
    // Nav
    $nav = (new Part())
      ->setTag(false)
      ->setName('nav')
      ->addHtml($this->getHeader());
    $this->body->insertPartBefore($nav);
  }

  function buildFooter() {
    $this->getBody()->addHtml($this->getFooter());
  }

  protected function buildHero() {
    if ($this->hero) {
      $this->getBody()->insertPartBefore($this->getHero());
    } else {
      $this->getBody()->addClass('no-hero');
    }
  }

  function build() {
    if (!$this->head) {$this->setHead();}
    $this->insertPartBefore($this->head);
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
