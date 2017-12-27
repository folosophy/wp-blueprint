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
    $this->setTag('section');
    $this->setName('hero');
  }

  function getContent() {
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
    wp_reset_query();
    $field = get_field('hero');
    $this->bg = (new Image())
      ->setClass('hero__bg');
    if ($field && $field['content_type'] == 'post_select') {
      $img_id = (int) get_post_thumbnail_id($field['post_select']);
      $this->bg->setSrc($img_id);
    }
  }

  protected function buildClass() {
    $this->class = "$this->type";
  }

  protected function buildInit() {
    if (empty($this->bg)) {$this->setBg();}
    if ($this->bg) {$this->addPart($this->bg);}
    $this->addPart($this->getContent());
    $this->buildClass();
    if (!$this->type) {$this->setType();}
    $this->addClass($this->type);
  }

}

//
//
// private function setContentType() {
//   $this->hero = get_field('hero');
//   $this->contentType = $this->hero['content_type'];
//   switch ($this->contentType) {
//     case ('default')     : $this->setDefault(); break;
//     case ('manual')      : $this->setManual(); break;
//     case ('latest_post') : $this->setLatestPost(); break;
//     //case ('select_post') : $this->setSelectPost(); break;
//   }
// }
//
// function setDefaultHeadline($headline) {
//   $this->defaultHeadline = $headline;
//   return $this;
// }
//
// function setHeadline($headline,$chain=false) {
//   $this->headline = $headline;
//   return $this;
// }
//
// function setType($type=null) {
//   if (!$type) {$type = 'secondary';}
//   $this->type = 'hero-' . $type;
//   return $this;
// }
//
// protected function setDefault() {
//   if (!$this->headline) {$this->headline = get_the_title();}
//   $this->setBg();
//   if ($this->type == 'hero-primary') {
//     if (!$this->defaultButton) {
//       $this->setDefaultButton();
//     }
//   }
// }
//
// protected function setManual() {
//   $this->headline = get_field('hero_headline');
//   $this->options  = get_field('hero_options');
//   $this->setBg();
//   //$button = new ButtonConditional($this->groupName);
//   //$this->button = $button->build();
// }
//
// protected function setLatestPost() {
//   $args  = array('post_type'=>'post','numberposts'=>1);
//   $posts = get_posts($args); global $post;
//
//   foreach ($posts as $post) : setup_postdata($post);
//     $this->headline = get_the_title();
//     $button_link    = get_permalink();
//     $button = new Button('light','Check it out',$button_link);
//     $this->button = $button->build();
//     $this->setBg();
//     $this->setSubHeadline();
//   endforeach; wp_reset_postdata();
// }
//
// function setClass($class) {
//   $this->class = $class;
// }
//
// function setBg($id=null) {
//   wp_reset_query();
//   $this->bg = (new Image())
//     ->setClass('hero__bg');
// }
//
// function setDefaultButton($label=null,$chain=false) {
//   if ($label !== false) {
//     if (!$label) {$label = 'Learn More';}
//     $button = (new Button($label))
//       ->addClass('hero-button')
//       ->setType('light')
//       ->setLink('#section-next');
//     array_push($this->buttons,$button);
//     return $this->chain($button,$chain);
//   } else {
//     return $this;
//   }
// }
//
// function setSecondaryButton($label,$chain=false) {
//   $button = (new Button($label))
//     ->addClass('hero-button');
//   array_push($this->buttons,$button);
//   return $this->chain($button,$chain);
// }
//
// public function setSubHeadline() {
//   $cat  = get_the_category();
//   $name = $cat[0]->name;
//   $this->subHeadline = $name;
// }
//
// function preBuild() {
//
//   if (get_field('hero')) {
//     $this->setContentType();
//   } else {
//     $this->setBg();
//     $this->class .= ' hero-single ';
//   }
//
//   if ($this->buttons) {
//     $this->buttonGroup = "<div class='hero__buttons'>";
//     foreach ($this->buttons as $button) {
//       $this->buttonGroup .= $button->build();
//     }
//     $this->buttonGroup .= "</div>";
//   }
// }
//
// function build() {
//   $this->preBuild();
//   if ($this->defaultHeadline && $this->contentType = 'default') {
//     $this->headline = $this->defaultHeadline;
//   }
//   $headline     = $this->headline;
//   $sub_headline = $this->subHeadline;
//   if ($this->bg !== false) {
//     if (!$this->bg) {$this->setBg();}
//     $bg = $this->bg->build();
//   }
//   else {$bg = null;}
//   $class        = $this->class;
//   if ($sub_headline) {$sub_headline = "<h2>— $sub_headline —</h2>";}
//   // TODO: convert to part build
//   $parts = $this->buildParts();
//   return "
//     <section class='$this->type $class'>
//       $bg
//       $parts
//       <div class='hero-wrap'>
//         <div class='hero__content'>
//           $sub_headline
//           <h1 class='hero__headline'>$headline</h1>
//           $this->buttonGroup
//         </div>
//       </div>
//     </section>
//   ";
// }

class HeroContent extends Part {

  protected $buttons;
  protected $button;
  protected $primaryButton;
  protected $secondaryButton;
  protected $defaultHeadline;
  protected $headline;

  function init() {
    $this->addClass('hero__content');
    $this->field = get_field('hero');
    if ($this->field) {
      switch ($this->field['content_type']) {
        case 'manual' : $this->setManualContent();
        case 'post_select' : $this->setPostSelectContent();
      }
    }
  }

  function getButtons() {
    if (!isset($this->buttons)) {$this->setButtons();}
    return $this->buttons;
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

  protected function setButtons() {
    $this->buttons = (new Part())
      ->addClass('hero__buttons');
    return $this->buttons;
  }

  function setDefaultButton($name=null,$chain=false) {
    $button = $this->makeButton();
    return $this->setPart($button,$chain,'defaultButton');
  }

  function setHeadline($headline=null) {
    if (!$headline == false) {
      if ($this->field['headline']) {
        $this->headline = $this->field['headline'];
      }
    } else {
      $this->headline = false;
    }
    return $this;
  }

  function setManualContent() {
    // TODO: create static function for retreiving button stuff
    if ($this->field['headline']) {
      $this->headline = $this->field['headline'];
    }
    $field = $this->field['button'];
    $target = $field['link_target'];
    switch ($target) {
      case 'internal': $link = get_permalink($field['internal_link']); break;
      case 'external': $link = $field['external_link']; break;
      case 'section':  $link = $field['section_link']; break;
    }
    $button = $this->setButton(null,true)
      ->setLabel($field['label'])
      ->setLink($link);
    if ($target == 'external') {$button->setTarget();}
    return $this;
  }

  function setPostSelectContent() {
    $this->setHeadline();
    $button_field = $this->field['button'];
    $link = get_permalink($this->field['post_select']);
    $button = $this->setButton(null,true)
      ->setLabel($button_field['label'])
      ->setLink($link);
    return $this;
  }

  function setSecondaryButton($name=null,$chain=true) {
    $button = $this->makeButton()
      ->addClass('hero__button-secondary');
    return $this->setPart($button,$chain,'secondaryButton');
  }

  function setButton($name=null,$chain=false) {
    $button = $this->makeButton();
    return $this->setPart($button,$chain,'button');
  }

  function setDefaultHeadline($headline) {
    $this->defaultHeadline = $headline;
    return $this;
  }

  function makeButton() {
    if (!isset($this->buttons)) {$this->setButtons();}
    return (new Button())
      ->setType('hero')
      ->addClass('hero__button')
      ->setLabel('Learn More')
      ->setLink('#section-next');
  }

  function prepareButtons() {
    if (isset($this->button)) {
      $this->getButtons()
        ->addPart($this->button);
    } elseif (isset($this->defaultButton)) {
      $this->getButtons()
        ->addPart($this->defaultButton);
    }
    if (isset($this->secondaryButton)) {
      $this->getButtons()
        ->addPart($this->secondaryButton);
    }
    return $this->buttons;
  }

  function buildInit() {
    if ($this->getHeadline()) {
      $this->addHeadline($this->getHeadline(),true)
        ->setTag('h1')
        ->addClass('hero__headline');
    }
    $this->addPart($this->prepareButtons());
  }

}
