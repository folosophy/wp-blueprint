<?php

namespace Blueprint\Part;

class Video extends Part {

  // Get YouTube thumbnail
  // https://img.youtube.com/vi/hBvcngHRTFg/0.jpg

  protected $autoPlay;
  protected $container;
  protected $field;
  protected $isBg;
  protected $playButton;
  protected $hasThumbnail;
  protected $host;
  protected $thumbnail;
  protected $video;
  protected $videoAtts;
  protected $videoField;
  protected $videoKey;
  protected $src;

  function init() {
    $name = $this->name;
    if ($name) {
      if (is_array($name)) {$this->setField($name);}
    }
    $this->setClass('container-video');
  }

  function getVideo() {
    return $this->checkSet('video');
  }

  function getVideoKey() {
    if (!isset($this->videoKey)) {$this->setVideoKey();}
    return $this->videoKey;
  }

  protected function getVideoSrc() {

    if (!$this->host) {$this->host = 'youtube';}

    if ($this->host == 'youtube') {
      $src = "https://www.youtube.com/embed/$this->videoKey?rel=0&amp;showinfo=0";
    }
    elseif ($this->host == 'vimeo') {
      $src = "https://player.vimeo.com/video/$this->videoKey?title=0&byline=0&portrait=0";
    }

    if ($this->thumbnail) {$src .= '&autoplay=1';}
    return $src;

  }

  function setAutoPlay($auto=null) {
    $this->autoPlay = $auto;
  }

  function setField($field=null) {
    parent::setField($field);
    $field = $this->field;
    if ($field) {
      if (isset($field['video'])) {$field = $field['video'];}
      $host = $field['host'];
      $this->host = $host;
      $this->setVideoKey($field[$host . '_id']);
      if (isset($field['thumbnail']) && $field['thumbnail'] !== false) {
        $this->setThumbnail($field['thumbnail']);
      }
    }
    return $this;
  }

  function setThumbnail($src) {
    $this->thumbnail = (new Image($src))
      ->setClass('img-bg video__thumbnail');
  }

  function setVideo() {
    $this->video = (new Part())
      ->setClass('video img-bg');
  }

  // function isBg($isBg=false) {
  //   $this->isBg = $isBg;
  //   return $this;
  // }
  //

  function setHost($host='youtube') {
    $hosts = array('youtube','vimeo');
    if (!in_array($host,$hosts)) {wp_die('part/Video sethost invalid host.');}
    $this->host = $host;
    return $this;
  }


  function setVideoKey($key=null) {
    $field = $this->field;

    $this->videoKey = $key;
    return $this;
  }

  //
  // // TODO: #toaddpart
  // function setThumbnail() {
  //   if ($this->field && $this->field['thumbnail']) {
  //     $imgId = $this->field['thumbnail'];
  //     $this->thumbnail = (new Image())
  //       ->setSrc($imgId)
  //       ->addClass('img-bg')
  //       ->setSize('blog')
  //       ->build();
  //     $this->playButton = "<div class='button-play'></div>";
  //   }
  //   return $this;
  // }
  //

  // protected function setYoutube() {
  //   $this->src = "https://www.youtube.com/embed/$this->videoId?rel=0&amp;controls=0&amp;showinfo=0";
  //   $this->videoAtts = "frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen";
  // }
  //
  // protected function setVimeo() {
  //   $this->src = "https://player.vimeo.com/video/$this->videoId?title=0&byline=0&portrait=0";
  //   $this->videoAtts = "frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen";
  // }

  //
  // function buildInit() {
  //
  //   if (!isset($this->field)) {$this->field = get_field('video');}
  //   elseif (is_string($this->field)) {$this->field = get_field($this->field);}
  //   if (isset($this->field['video'])) {$this->field = $this->field['video'];}
  //
  //   if ($this->isBg == true) {$this->addClass('img-bg');}
  //   else {$this->addClass('container-iframe');}
  //   if (!$this->host) {$this->setHost();}
  //
  //   if (!$this->videoId) {
  //     if ($this->field) {
  //       $this->host = $this->field['host'];
  //       $this->videoId = $this->field[$this->host . '_id'];
  //       $this->setThumbnail();
  //     }
  //   }
  //
  //   // Set host method
  //   $method = 'set' . ucwords($this->host);
  //   $this->$method();
  //   $this->part = "
  //     <iframe
  //       class='img-bg'
  //       src='$this->src'
  //       play-src='$this->src&autoplay=1'
  //       reset-src='$this->src'
  //       $this->videoAtts
  //     ></iframe>
  //     <div class='theater-exit'></div>
  //     $this->playButton
  //     $this->thumbnail
  //     ";
  //
  // }

  function prepareVideo() {
    $video = $this->getVideo();
    if (!$this->videoKey) {$this->setVideoKey();}

    $video
      ->setTag('iframe')
      ->setAttr('frameborder',0)
      ->setAttr('webkitallowfullscreen')
      ->setAttr('mozallowfullscreen')
      ->setAttr('allowfullscreen');

    $this->insertPart($video);

    if ($this->thumbnail) {
      $video->setAttr('data-src',$this->getVideoSrc());
      $this->insertPart($this->thumbnail);
      $this->addPart()
        ->setClass('video__play_button');
    } else {
      $video->setAttr('src',$this->getVideoSrc());
    }

  }

  function build() {
    $this->prepareVideo();
    return parent::build();
  }

}
