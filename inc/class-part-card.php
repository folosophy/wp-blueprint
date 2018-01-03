<?php

namespace Blueprint\Part;
use Blueprint as bp;

class Card extends Part {

  protected $body;
  protected $class;
  protected $content;
  protected $excerpt;
  protected $media;
  protected $mediaField;
  protected $reverse;
  protected $mediaType;
  protected $title;
  protected $link;
  protected $subHeadline;

  protected function init() {
    \bp_log_post();
    $this->setType();
    $this->setAttr('href',get_the_permalink());
    $this->setLazy();
    $this->addClass('card-' . get_post_type());
  }

  protected function setBody() {
    $this->setMedia();
    $this->setContent();
    if ($this->reverse) {
      $this->body = $this->content . $this->media;
    } else {
      $this->body = $this->media . $this->content;
    }
  }

  protected function setTitle() {
    $this->title = get_the_title();
  }

  protected function setContent() {
    $this->setTitle();
    if (!$this->subHeadline) {$this->setSubHeadline();}

    if (bp_var('card_excerpt') !== null) {
      $this->setExcerpt();
      if ($this->excerpt) {$excerpt = "<p class='p2'>$this->excerpt</p>";}
      else {$excerpt = null;}
    }

    $this->content = "
      <div class='card__content'>
        $this->subHeadline
        <h5>$this->title</h5>
        $excerpt
      </div>
    ";
  }

  function setExcerpt($excerpt=null) {
    if (!$excerpt) {$excerpt = get_the_excerpt();}
    if ($excerpt) {
      $excerpt = wp_strip_all_tags($excerpt,true);
      $excerpt = limit_words($excerpt,200);
    }
    $this->excerpt = $excerpt;
    return $this;
  }

  protected function setType($type = null) {
    if (!$type) {$type = 'article';}
    $this->$type = $type;
    $this->addClass('card-' . $type . ' card-' . get_post_type());
  }

  function getImg($img = null) {
    if (!$img) {
      $this->setImg();
    }
    return $this->img;
  }

  function setImg() {
    $this->img = (new Image())
      ->setClass('img-bg');
    return $this->img;
  }

  function setMedia($media=null) {
    $field = get_field('featured_media');
    $media_format = $field['format'];
    $media = $this->getImg()->build();
    $this->media = "
      <div class='card__media'>
        $media
      </div>
    ";
  }

  function setSubHeadline($headline=null) {
    if (!$headline) {
      $pt = get_post_type();
      $cat = get_field($pt . '_category');
    }
    $class = 'sub-headline-' . get_post_type();
    $this->subHeadline = "<h4 class='$class'>$headline</h4>";
    return $this;
  }

  function buildInit() {
    $this->setBody();
    $this->setTag('a');
    $this->addHtml($this->body);
  }

}
