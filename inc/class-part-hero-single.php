<?php

// TODO: convert to part build

namespace Blueprint\Part\Hero;
use Blueprint\Part as part;

class Single extends part\Hero {

  protected $field_featuredMedia;
  protected $featuredMedia;
  protected $mediaFormat;

  function init() {
    $this->setFeaturedMedia();
    parent::init();
  }

  protected function setFeaturedMedia() {
    $field = get_field('featured_media');
    $this->field_featuredMedia = $field;
    $this->mediaFormat = $field['format'];
  }

  protected function buildFeaturedMedia() {
    switch ($this->mediaFormat) {
      case    'video' : $featuredMedia = $this->buildVideo(); break;
      default         : $featuredMedia = null;
    }
    $this->featuredMedia = $featuredMedia;
    $this->addPart($featuredMedia);
    return $featuredMedia;
  }

  protected function buildVideo() {
    $field = $this->field_featuredMedia['video'];
    // Patch for duplicate field group bug
    if (isset($field['video'])) {$field = $field['video'];}
    $video_id = $field[$field['source'] . '_id'];
    $video = (new part\Video())
      ->setVideoId($video_id)
      ->setClass('img-bg');
    return $video;
  }

  protected function buildInit() {
    parent::buildInit();
    $this->buildFeaturedMedia();
  }

}
