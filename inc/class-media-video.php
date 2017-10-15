<?php

namespace Blueprint\Media;

class Video extends Media {

  protected $field;
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
    }
    return $this;
  }

  function setYoutube() {
    $this->videoSrc = "https://www.youtube.com/embed/$this->videoId?rel=0&amp;controls=0&amp;showinfo=0";
    $this->videoAtts = "frameborder='0' allowfullscreen";
  }

  function setVimeo() {
    $this->videoSrc = "https://player.vimeo.com/video/$this->videoId";
    $this->videoAtts = "frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen";
  }

  function build() {
    return "
      <div class='container-medium'>
        <div class='container-iframe'>
          <iframe class='img-bg' src='$this->videoSrc' $this->videoAtts></iframe>
          $this->thumbnail
        </div>
      </div>
    ";
  }

}
