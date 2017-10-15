<?php

namespace Blueprint\Part;

class Hero extends Part {

  function __construct() {
    $this->setContentType();
    $this->setType();
  }

  protected $contentType;
  protected $buttons = array();
  protected $buttonGroup;
  protected $copy;
  protected $defaultHeadline;
  protected $headline;
  protected $hero;
  protected $subHeadline;
  protected $style;
  protected $type;
  protected $class;
  protected $bg;

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

  public function setType($type=null) {
    if (!$type) {$type = 'secondary';}
    $this->type = 'hero-' . $type;
    return $this;
  }

  protected function setDefault() {
    $this->headline = get_the_title();
    $this->setBg();
    $this->setDefaultButton();
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

  public function setClass($class) {
    $this->class = $class;
  }

  public function setBg($id=null) {
    $this->bg = bp_get_img('hero__bg');
  }

  function setDefaultButton($label=null,$chain=false) {
    if (!$label) {$label = 'Learn More';}
    $button = (new Button('light',$label))
      ->addClass('hero-button');
    array_push($this->buttons,$button);
    return $this->chain($button,$chain);
  }

  function setSecondaryButton($label,$chain=false) {
    $button = (new Button('light',$label))
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
    $bg           = $this->bg;
    $class        = $this->class;
    if ($sub_headline) {$sub_headline = "<h2>— $sub_headline —</h2>";}
    return "
      <section class='$this->type $class'>
        $bg
        <div class='hero-wrap'>
          <div class='hero__content center'>
            $sub_headline
            <h1 class='hero-headline'>$headline</h1>
            $this->buttonGroup
          </div>
        </div>
      </section>
    ";
  }

}

/*

// Headline
if (!$headline) {$headline = get_the_title();}

// Copy
if ($copy) {
  if (!$button) {$copy_class = 'last';}
  $copy = "<p class='$copy_class'>$copy</p>";
}

// Background
if (has_post_thumbnail()) {
  $hero_bg = ps_get_ft_img('hero__bg','hero');
} else {
  $id =  get_option('page_on_front');
  $hero_bg = ps_get_ft_img('hero__bg','hero',array('id'=>$id));
}

// Border Bottom
$border_bottom = "<img src='" . get_template_directory_uri() . "/assets/img/wave-white-bottom.svg' class='wave-bottom' />";

// Button
if (is_array($options) && in_array('button',$options)) {
  $target  = get_field('hero_button_link_target');
  $text    = get_field('hero_button_text');
  switch ($target) :
    case ('external') : $link = get_field('hero_button_external_link'); break;
    case ('internal') : $link = get_permalink(get_field('hero_button_internal_link')); break;
    case ('phone')    :
      $num  = get_field('hero_button_phone_number');
      $num  = '(' . substr($num,0,3) . ') ' . substr($num,3,3) . '-' . substr($num,6,9);
      $link = 'tel:' . $num; break;
  endswitch;
  $button  = "
    <hr class='spacer-md' />
    <a class='btn-primary' title='$link' href='$link'>$text</a>
  ";
}

$el = "
  <section class='hero-primary'>
    $hero_bg
    <div class='hero__content center'>
      <h1>$headline</h1>
      <div class='container-sm'>
        $copy
        $button
      </div>
    </div>
    $border_bottom
  </section>
";

echo $el;
*/
