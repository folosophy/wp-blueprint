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
    $this->setType($this->name);
    $this->setTag('section');
    $this->setName('hero');
  }

  function getHeroContent() {
    if (!isset($this->content)) {$this->setContent();}
    return $this->content;
  }

  function setContent() {
    $this->content = (new HeroContent());
    return $this->content;
  }

  function setType($type=null) {
    if (!$type) {$type = 'secondary';}
    $this->type = 'hero-' . $type;
    return $this;
  }

  function setBg($id=null) {
    if ($id === false) {
      $this->bg = false;
    } else {
      wp_reset_query();
      $field = get_field('hero');
      $this->bg = (new Image())
        ->setClass('hero__bg');
      if ($field && $field['content_type'] == 'post_select') {
        $img_id = (int) get_post_thumbnail_id($field['post_select']);
        if ($img_id) {$this->bg->setSrc($img_id);}
      }
    }
    return $this;
  }

  protected function buildClass() {
    $this->class = "$this->type";
  }

  protected function buildInit() {
    if (empty($this->bg)) {$this->setBg();}
    if ($this->bg) {$this->addPart($this->bg);}
    $this->addPart($this->getHeroContent());
    $this->buildClass();
    if (!$this->type) {$this->setType();}
    $this->addClass($this->type);
  }

}

class HeroContent extends Part {

  protected $buttons;
  protected $button;
  protected $copy;
  protected $primaryButton;
  protected $secondaryButton;
  protected $defaultHeadline;
  protected $headline;

  function init() {
    $this->addClass('hero__content');
    $this->field = get_field('hero');
    if ($this->field) {
      switch ($this->field['content_type']) {
        case 'manual' : $this->setManualContent(); break;
        case 'post_select' : $this->setPostSelectContent(); break;
      }
    }
  }

  function getButton() {
    if (!isset($this->button)) {$this->setButton();}
    return $this->button;
  }

  function getButtons() {
    if (!isset($this->buttons)) {$this->setButtons();}
    return $this->buttons;
  }

  function getCopy() {
    if (!isset($this->copy)) {$this->setCopy();}
    return $this->copy;
  }

  function getHeadline() {
    if (!isset($this->headline)) {
      if (isset($this->defaultHeadline)) {
        $this->headline = $this->defaultHeadline;
      } else {
        $this->headline = get_the_title();
      }
    }
    return $this->headline;
  }

  function getSecondaryButton() {
    if (!isset($this->secondaryButton)) {$this->setSecondaryButton();}
    return $this->secondaryButton;
  }

  protected function setButtons() {
    $this->buttons = (new Part())
      ->addClass('hero__buttons');
    return $this->buttons;
  }

  function setDefaultButton($name=null,$chain=false) {
    $button = $this->makeButton($name);
    return $this->setPart($button,$chain,'defaultButton');
  }

  function setHeadline($headline=null) {
    if ($headline === false) {
      $this->headline = false;
    } elseif ($headline) {
      $this->headline = $headline;
    } else {
      if ($this->field['headline']) {
        $this->headline = $this->field['headline'];
      }
    }
    return $this;
  }

  function setManualContent() {
    // TODO: create static function for retreiving button stuff
    $this->setHeadline();
    $field = $this->field['button'];
    $button = $this->setButton(null,true);
    return $this;
  }

  function setPostSelectContent() {
    $this->setHeadline();
    $button = $this->setButton(null,true)
      ->setLink($this->field['post_select'],'internal')
      ->setLabel($this->field['button_text']);
    return $this;
  }

  function setSecondaryButton($name=null,$chain=true) {
    $this->secondaryButton = $this->makeButton($name)
      ->addClass('hero__button hero__button-secondary');
    if ($chain) {return $this->secondaryButton;}
    else {return $this;}
  }

  function setButton($name=null,$chain=false) {
    $button = $this->makeButton()
      ->setField(get_field('hero_button'))
      ->addClass('hero__button hero__button-primary');
    return $this->setPart($button,$chain,'button');
  }

  function setCopy($copy=null) {
    $this->copy = (new Text($copy))
      ->setTag('p')
      ->setClass('hero__copy');
    return $this;
  }

  function setDefaultHeadline($headline) {
    $this->defaultHeadline = $headline;
    return $this;
  }

  function makeButton($label) {
    return (new Button())
      ->setLabel($label)
      ->setType('hero')
      ->addClass('hero__button');
  }

  function prepareButtons() {
    if (isset($this->button)) {
      $this->getButtons()
        ->insertPart($this->button);
    } elseif (isset($this->defaultButton)) {
      $this->getButtons()
        ->insertPart($this->defaultButton);
    }
    if (isset($this->secondaryButton)) {
      $this->getButtons()
        ->insertPart($this->secondaryButton);
    }
    return $this->buttons;
  }

  function buildInit() {
    $wrap = $this->addPart()
      ->setClass('hero__content__wrap');
    if ($this->getHeadline()) {
      $h = $wrap->addH($this->getHeadline(),true)
        ->setTag('h1')
        ->addClass('hero__headline');
    }
    if ($this->copy) {$wrap->insertPart($this->copy);}
    $wrap->addPart($this->prepareButtons());
  }

}
