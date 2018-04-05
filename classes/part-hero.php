<?php

// TODO: convert to part build

namespace Blueprint\Part;

class Hero extends Part {

  protected $content;
  protected $style;
  protected $type;
  protected $class;
  protected $bg;

  use HeroContent;

  function init() {
    $this->setType($this->name);
    $this->setTag('section');
    $this->setName('hero');
    $this->addClass('hero');
    $this->setHeroContent();
  }

  function setContent($bool) {
    if (!$bool) {$this->content = false;}
    return $this;
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
      $id = get_post_thumbnail_id();
      $this->bg = (new Image())
        ->setSrc($id)
        ->setClass('hero__bg bg');
    }
    return $this;
  }

  protected function buildClass() {
    $this->class = "$this->type";
  }

  protected function buildInit() {

    if ($this->bg || $this->bg === null) {$this->setBg();}
    if ($this->bg) {$this->addPart($this->bg);}
    $this->prepareHeroContent();
    $this->buildClass();
    if (!$this->type) {$this->setType();}
    $this->addClass($this->type);

  }

}

trait HeroContent {

  protected $contentType;
  protected $buttons;
  protected $buttonField;
  protected $buttonGroup;
  protected $copy;
  protected $defaultButton;
  protected $defaultHeadline;
  protected $headline;
  protected $hero;
  protected $subHeadline;
  protected $button;
  protected $primaryButton;
  protected $secondaryButton;
  protected $defaultCopy;
  protected $heroContent;

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

  function getDefaultCopy() {
    if (!isset($this->defaultCopy)) {$this->setDefaultCopy();}
    return $this->defaultCopy;
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

  function getHeroContent() {
    if (!isset($this->heroContent)) {$this->setHeroContent();}
    return $this->heroContent;
  }

  function setDefaultCopy($copy=null) {
    $this->defaultCopy = (new Text($copy))
      ->setLazy(true)
      ->addClass('hero__copy');
    return $this;
  }

  function setHeroContent() {
    $this->heroContent = (new Part('hero__content'));
    $this->field = get_field('hero');
    if ($this->field) {
      switch ($this->field['content_type'] ?? 'default') {
        case 'manual' : $this->setManualContent(); break;
      }
    }
    return $this->heroContent;
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
    $button = $this->makeButton($name)
      ->addClass('hero__button-primary');
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
    $this->setHeadline();
    $this->buttonField = $this->field['button'] || null;
    $button = $this->setButton();
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

  function setSubHeadline($headline=null) {
    $this->subHeadline = (new Headline($headline))
      ->setTag('h4');
    return $this;
  }

  function setButton($name=null,$chain=false) {

    if (is_array($name)) {
      $field = $name;
    } elseif ($this->buttonField) {
      $field = $this->buttonField;
    }

    $button = $this->makeButton($field['label'])
      ->setField(get_field('hero_button'))
      ->addClass('hero__button hero__button-primary');
    return $this->setPart($button,$chain,'button');

  }

  function setCopy($copy=null) {
    if ($copy === false) {
      $this->copy = false;
    } else {
      $this->copy = (new Text($copy))
        ->setTag('p')
        ->setClass('hero__copy');
    }
    return $this;
  }

  function setDefaultHeadline($headline) {
    $this->defaultHeadline = $headline;
    return $this;
  }

  function makeButton($label) {
    $button = (new Button())
      ->setLabel($label)
      ->setType('hero')
      ->addClass('hero__button');
    return $button;
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
    if ($this->buttons) {
      $this->content->addPart($this->buttons);
    }
  }

  function prepareHeroContent() {

    if ($this->content === false) {return false;}

    $content = $this->content = $this->addPart('hero__content');

    if ($this->subHeadline) {
      $wrap->addPart($this->subHeadline);
    }

    if ($this->getHeadline()) {
      $h = $content->addh2($this->getHeadline(),true)
        ->setTag('h1')
        ->addClass('hero__headline');
    }

    if ($this->copy === false) {
    } else {
      if ($this->copy) {$content->insertPart($this->copy);}
      elseif ($this->defaultCopy) {$content->addPart($this->getDefaultCopy());}
    }

    $this->prepareButtons();

  }

}
