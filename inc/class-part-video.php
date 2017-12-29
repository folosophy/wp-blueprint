<?php

namespace Blueprint\Part;

class Video extends Part {

  // Get YouTube thumbnail
  // https://img.youtube.com/vi/hBvcngHRTFg/0.jpg

  protected $field;
  protected $isBg;
  protected $playButton;
  protected $host;
  protected $thumbnail;
  protected $video;
  protected $videoAtts;
  protected $videoId;
  protected $src;

  function isBg($isBg=false) {
    $this->isBg = $isBg;
    return $this;
  }

  function setHost($host='youtube') {
    $hosts = array('youtube','vimeo');
    if (!in_array($host,$hosts)) {wp_die('part/Video sethost invalid host.');}
    $this->host = $host;
    return $this;
  }

  function setVideoId($id) {
    $this->videoId = $id;
    return $this;
  }

  // TODO: #toaddpart
  function setThumbnail() {
    if ($this->field && $this->field['thumbnail']) {
      $imgId = $this->field['thumbnail'];
      $this->thumbnail = (new Image())
        ->setSrc($imgId)
        ->addClass('img-bg')
        ->setSize('blog')
        ->build();
      $this->playButton = "<div class='button-play'></div>";
    }
    return $this;
  }

  function setYoutube() {
    $this->src = "https://www.youtube.com/embed/$this->videoId?rel=0&amp;controls=0&amp;showinfo=0";
    $this->videoAtts = "frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen";
  }

  function setVimeo() {
    $this->src = "https://player.vimeo.com/video/$this->videoId?title=0&byline=0&portrait=0";
    $this->videoAtts = "frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen";
  }

  function buildInit() {

    if (!isset($this->field)) {$this->field = get_field('video');}
    elseif (is_string($this->field)) {$this->field = get_field($this->field);}
    if (isset($this->field['video'])) {$this->field = $this->field['video'];}

    if ($this->isBg == true) {$this->addClass('img-bg');}
    else {$this->addClass('container-iframe');}
    if (!$this->host) {$this->setHost();}

    if (!$this->videoId) {
      if ($this->field) {
        $this->host = $this->field['host'];
        $this->videoId = $this->field[$this->host . '_id'];
        $this->setThumbnail();
      }
    }

    // Set host method
    $method = 'set' . ucwords($this->host);
    $this->$method();
    $this->part = "
      <iframe
        class='img-bg'
        src='$this->src'
        play-src='$this->src&autoplay=1'
        reset-src='$this->src'
        $this->videoAtts
      ></iframe>
      <div class='theater-exit'></div>
      $this->playButton
      $this->thumbnail
      ";

  }

}
