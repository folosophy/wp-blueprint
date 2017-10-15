<?php

namespace Blueprint\Part;
use Blueprint as bp;

class Card extends Part {

  protected $body;
  protected $class;
  protected $content;
  protected $media;
  protected $reverse;
  protected $mediaType;
  protected $title;
  protected $subHeadline;

  protected function init() {
    $this->setTitle();
    $this->setSubHeadline();
    $this->setMedia();
    $this->setType();
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
    $this->content = "
      <div class='card__content'>
        $this->subHeadline
        <h5>$this->title</h5>
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

  protected function getField($name) {
    return get_field(get_post_type() . '_' . $name);
  }

  function setMedia($media=null) {
    $media_format = get_field(get_post_type() . '_media_format');
    switch ($media_format) {
      case 'video' :
        $source = $this->getField('video_source');
        switch ($source) {
          case 'youtube' : $video_id   = $this->getField('youtube_video_id');
        }
        $media = (new \Blueprint\Media\Video($video_id,$source))->build();
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
      $cats = get_the_terms(get_the_id(),get_post_type() . '_category');
    }
    if ($cats) {$headline = $cats[0]->name;}
    else {$headline = 'Uncategorized';}
    $class = 'sub-headline-' . get_post_type();
    $this->subHeadline = "<h4 class='$class'>$headline</h4>";
    return $this;
  }

  function build() {
    $this->setBody();
    bp\log_post();
    return "
      <div class='$this->class'>
        $this->body
      </div>
    ";
  }

}
