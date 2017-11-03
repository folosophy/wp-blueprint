<?php

namespace Blueprint\Part;

class Video extends Part {

  protected $field;
  protected $playButton;
  protected $thumbnail;
  protected $video;
  protected $videoAtts;
  protected $videoId;
  protected $videoSrc;

  function __construct($id,$source='youtube') {
    if (is_array($id)) {
      $field = $id;
      $this->field = $field;
      $source = $field['source'];
      $id = $field[$source . '_id'];
      $this->setThumbnail();
    }
    $this->videoId = $id;
    $method = 'set' . ucwords($source);
    $this->$method();
  }

  function setThumbnail() {
    if ($this->field && $this->field['thumbnail']) {
      $this->thumbnail = \bp_get_img('img-bg','medium',$this->field['thumbnail']);
      $this->playButton = "<div class='button-play'></div>";
    }
    return $this;
  }

  function setYoutube() {
    $this->videoSrc = "https://www.youtube.com/embed/$this->videoId?rel=0&amp;controls=0&amp;showinfo=0";
    $this->videoAtts = "frameborder='0' allowfullscreen";
  }

  function setVimeo() {
    $this->videoSrc = "https://player.vimeo.com/video/$this->videoId?showinfo=0";
    $this->videoAtts = "frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen";
  }

  function build() {
    return "
      <iframe
        class='img-bg'
        src='$this->videoSrc'
        play-src='$this->videoSrc&autoplay=1'
        reset-src='$this->videoSrc'
        $this->videoAtts
      ></iframe>
      <div class='theater-exit'></div>
      $this->playButton
      $this->thumbnail
    ";
  }

}
