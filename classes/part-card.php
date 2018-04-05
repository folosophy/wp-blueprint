<?php

namespace Blueprint\Part;
use Blueprint as bp;

class Card extends Part {

  protected $body;
  protected $buildType;
  protected $class;
  protected $cardContent;
  protected $img;
  protected $excerpt;
  protected $media;
  protected $mediaField;
  protected $reverse;
  protected $mediaType;
  protected $title;
  protected $link;
  protected $post;
  protected $subTitle;
  protected $type;

  function init() {
    if ($this->name) {
      if (is_int($this->name)) {
        $this->setPost($this->name);
      }
      elseif (is_string($this->name)) {$this->setType($this->name);}
    }
    $this->setLazy(true);
  }

  function getMedia() {
    $media = $this->checkSet('media');
    return $media;
  }

  function getSubTitle() {
    $title = $this->checkSet('subTitle');
    return $title;
  }

  function getTitle($format='part') {
    // TODO: args for return type
    $title = $this->checkSet('title');
    return $this->title->$format;
  }

  function getType() {
    return $this->checkSet('type');
  }

  protected function setTitle() {
    $this->title       = (object) array();
    $this->title->text = get_the_title($this->post_id);
    $this->title->part = (new Text($this->title->text))
      ->setTag('h3')
      ->setClass('card__title');
    return $this->title->part;
  }

  function getCardContent() {
    $this->checkSet('content');
    return $this->content;
  }

  function getExcerpt() {
    return $this->checkSet('excerpt');
  }

  protected function setContent() {
    $this->content = (new Part())
      ->setClass('card__content');
    return $this->content;
    // $this->setTitle();
    // if (!$this->subHeadline) {$this->setSubHeadline();}
    //
    // // If excerpts enabled
    // if (bp_var('card_excerpt') && $this->excerpt !== false) {
    //   $this->setExcerpt();
    //   if ($this->excerpt) {$excerpt = "<p class='p2'>$this->excerpt</p>";}
    //   else {$excerpt = null;}
    // } else {
    //   $excerpt = null;
    // }
    //
    // $this->content = "
    //   <div class='card__content'>
    //     $this->subHeadline
    //     <h5>$this->title</h5>
    //     $excerpt
    //   </div>
    // ";
  }

  function setExcerpt($excerpt=null) {
    if (!$excerpt) {
      $excerpt = get_field('excerpt',$this->post_id) ?: get_the_excerpt($this->post_id);
    }
    if ($excerpt) {
      $excerpt = wp_strip_all_tags($excerpt,true);
      $excerpt = limit_words($excerpt,120);
    }
    $this->excerpt = (new Text($excerpt))
      ->setTag('p')
      ->addClass('p2');
    return $this->excerpt;
  }

  function setType($type=null) {
    if (!$type) {$type = get_post_type($this->post_id);}
    $this->type = $type;
  }

  function getImg() {
    if (!isset($this->img)) {$this->setImg();}
    return $this->img;
  }

  function setImg() {
    $this->img = (new Image('xx'))
      ->setPost($this->post)
      ->setClass('img-bg');
    return $this->img;
  }

  function setMedia($media=null) {
    $this->media = (new Part())
      ->setClass('card__media');
    return $this->media;
    // $field = get_field('featured_media',$this->post_id);
    // $media_format = $field['format'];
    //
    // $img = get_post_thumbnail_id($this->post_id);
    // if (!$img & $field['format'] == 'video') {
    //   $this->getImg()->setSrc(bp_get_video_thumbnail(null,null,$this->post_id));
    // }
    // $media = $this->getImg()->build();
    //
    // $this->cardMedia = "
    //   <div class='card__media'>
    //     $media
    //   </div>
    // ";
  }

  function setSubTitle($title=null) {
    if (!$title) {
      $pt = get_post_type($this->post_id);
      $title = get_field($pt . '_category',$this->post_id) ?? 'Uncategorized';
      if (is_array($title)) {
        $term = get_term($title[0]);
        $title = $term->name;
      } elseif (is_object($title)) {
        $title = $title->name;
      }
    }
    if (!$title) {$title = get_post_type();}
    $this->subTitle = (new Text($title))
      ->setClass('card__sub-title')
      ->setTag('h4');
    return $this->subTitle;
  }

  function setBuildType($type) {
    $this->buildType = $type;
    return $this;
  }

  function buildInit() {

    $this->addClass('card-' . $this->getType());
    $this->addClass('card');

    if ($this->buildType == 'default') {

      $media = $this->addPart($this->getMedia())
        ->setLink(get_the_permalink())
        ->addImage()
          ->addClass('img-bg');

      $content = $this->addPart($this->getCardContent());

        $content->addPart($this->getSubTitle());
        $content->addPart($this->getTitle());
        $content->addPart($this->getExcerpt());
        $link = get_the_permalink($this->post_id);
        $content->addP2("<a href='$link'>Read More</a>");

    }

    \bp_log_post($this->post_id);
    //if ($this->link !== false) {$this->setAttr('href',get_the_permalink($this->post_id));}

  }

}
