<?php

// TODO: convert to part build

namespace Blueprint\Part;

class Hero extends Part {

  protected $contentType;
  protected $buttons = array();
  protected $buttonGroup;
  protected $copy;
  protected $defaultButton;
  protected $defaultHeadline;
  protected $headline;
  protected $hero;
  protected $subHeadline;
  protected $style;
  protected $type;
  protected $class;
  protected $bg;

  function init() {
    $this->setType();
  }

  private function setContentType() {
    $this->hero = get_field('hero');
    $this->contentType = $this->hero['content_type'];
    switch ($this->contentType) {
      case ('default')     : $this->setDefault(); break;
      case ('manual')      : $this->setManual(); break;
      case ('latest_post') : $this->setLatestPost(); break;
      //case ('select_post') : $this->setSelectPost(); break;
    }
  }

  function setDefaultHeadline($headline) {
    $this->defaultHeadline = $headline;
    return $this;
  }

  function setHeadline($headline,$chain=false) {
    $this->headline = $headline;
    return $this;
  }

  function setType($type=null) {
    if (!$type) {$type = 'secondary';}
    $this->type = 'hero-' . $type;
    return $this;
  }

  protected function setDefault() {
    if (!$this->headline) {$this->headline = get_the_title();}
    $this->setBg();
    if ($this->type == 'hero-primary') {
      if (!$this->defaultButton) {
        $this->setDefaultButton();
      }
    }
  }

  protected function setManual() {
    $this->headline = get_field('hero_headline');
    $this->options  = get_field('hero_options');
    $this->setBg();
    //$button = new ButtonConditional($this->groupName);
    //$this->button = $button->build();
  }

  protected function setLatestPost() {
    $args  = array('post_type'=>'post','numberposts'=>1);
    $posts = get_posts($args); global $post;

    foreach ($posts as $post) : setup_postdata($post);
      $this->headline = get_the_title();
      $button_link    = get_permalink();
      $button = new Button('light','Check it out',$button_link);
      $this->button = $button->build();
      $this->setBg();
      $this->setSubHeadline();
    endforeach; wp_reset_postdata();
  }

  function setClass($class) {
    $this->class = $class;
  }

  function setBg($id=null) {
    wp_reset_query();
    $this->bg = (new Image())
      ->setClass('hero__bg');
  }

  function setDefaultButton($label=null,$chain=false) {
    if ($label !== false) {
      if (!$label) {$label = 'Learn More';}
      $button = (new Button($label))
        ->addClass('hero-button')
        ->setType('light')
        ->setLink('#section-next');
      array_push($this->buttons,$button);
      return $this->chain($button,$chain);
    } else {
      return $this;
    }
  }

  function setSecondaryButton($label,$chain=false) {
    $button = (new Button($label))
      ->addClass('hero-button');
    array_push($this->buttons,$button);
    return $this->chain($button,$chain);
  }

  public function setSubHeadline() {
    $cat  = get_the_category();
    $name = $cat[0]->name;
    $this->subHeadline = $name;
  }

  function preBuild() {

    if (get_field('hero')) {
      $this->setContentType();
    } else {
      $this->setBg();
      $this->class .= ' hero-single ';
    }

    if ($this->buttons) {
      $this->buttonGroup = "<div class='hero__buttons'>";
      foreach ($this->buttons as $button) {
        $this->buttonGroup .= $button->build();
      }
      $this->buttonGroup .= "</div>";
    }
  }

  function build() {
    $this->preBuild();
    if ($this->defaultHeadline && $this->contentType = 'default') {
      $this->headline = $this->defaultHeadline;
    }
    $headline     = $this->headline;
    $sub_headline = $this->subHeadline;
    if ($this->bg !== false) {
      if (!$this->bg) {$this->setBg();}
      $bg = $this->bg->build();
    }
    else {$bg = null;}
    $class        = $this->class;
    if ($sub_headline) {$sub_headline = "<h2>— $sub_headline —</h2>";}
    // TODO: convert to part build
    $parts = $this->buildParts();
    return "
      <section class='$this->type $class'>
        $bg
        $parts
        <div class='hero-wrap'>
          <div class='hero__content'>
            $sub_headline
            <h1 class='hero__headline'>$headline</h1>
            $this->buttonGroup
          </div>
        </div>
      </section>
    ";
  }

}
