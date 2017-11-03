<?php

namespace Blueprint\Part;
use Blueprint as bp;

class Card extends Part {

  protected $body;
  protected $class;
  protected $content;
  protected $media;
  protected $mediaField;
  protected $reverse;
  protected $mediaType;
  protected $title;
  protected $link;
  protected $subHeadline;

  protected function init() {
    $this->setTitle();
    $this->setSubHeadline();
    $this->setMedia();
    $this->setType();
    $this->link = get_the_permalink();
  }

  protected function setBody() {
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
    $excerpt = get_the_excerpt();
    $this->content = "
      <div class='card__content'>
        $this->subHeadline
        <h5>$this->title</h5>
        <p class='p2'>$excerpt</p>
      </div>
    ";
  }


  protected function setType($type = null) {
    if (!$type) {$type = 'article';}
    $this->$type = $type;
    $this->class = 'card-' . $type;
  }

  function getImage($img = null) {
    if (!$img) {$img = bp_get_img('card__img','medium');}
    return $img;
  }

  function setMedia($media=null) {
    $field = get_field('featured_media');
    $media_format = $field['format'];
    switch ($media_format) {
      case 'video' :
        $video_field = $field['video'];
        if (isset($video_field['video'])) {
          $video_field = $video_field['video'];
        }
        $source      = $video_field['source'];
        switch ($source) {
          case 'youtube' : $video_id   = $video_field['youtube_id'];
        }
        $media = (new \Blueprint\Part\Video($video_id,$source))->build();
        break;
      default : $media = $this->getImage();
    }
    $this->media = "
      <div class='card__media'>
        $media
      </div>
    ";
  }

  function setSubHeadline($headline=null) {
    if (!$headline) {
      if (get_post_type() == 'post') {$cats = get_the_category();}
      //else {$cats = get_the_terms(get_the_id(),get_post_type() . '_category');}
      else {$cats = null;}
    }
    if ($cats) {$headline = $cats[0]->name;}
    else {$headline = 'Uncategorized';}
    $class = 'sub-headline-' . get_post_type();
    $this->subHeadline = "<h4 class='$class'>$headline</h4>";
    return $this;
  }

  function build() {
    $this->setBody();
    bp_log_post();
    return "
      <a class='$this->class' href='$this->link'>
        $this->body
      </a>
    ";
  }

}
