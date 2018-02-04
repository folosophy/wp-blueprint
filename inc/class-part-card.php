<?php

namespace Blueprint\Part;
use Blueprint as bp;

class Card extends Part {

  protected $body;
  protected $class;
  protected $content;
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
    if ($this->name) {$this->setType($this->name);}
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

  function getContent() {
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
    if (!$excerpt) {$excerpt = get_the_excerpt($this->post_id);}
    if ($excerpt) {
      $excerpt = wp_strip_all_tags($excerpt,true);
      $excerpt = limit_words($excerpt,200);
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
    }
    $this->subTitle = (new Text($title))
      ->setClass('card__sub-title')
      ->setTag('h4');
    return $this->subTitle;
  }

  function buildInit() {

    $this->addClass('card-' . $this->getType());


    \bp_log_post($this->post_id);
    //if ($this->link !== false) {$this->setAttr('href',get_the_permalink($this->post_id));}
  }

}
