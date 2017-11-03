<?php

namespace Blueprint\Part;

class Image extends Part {

  use MediaBuilder;

  protected $size;
  protected $class;
  protected $crop;
  protected $imgClass;
  protected $src;

  static function getSizes() {
    $sizes =  array(
      'blog' => array(
        'label' => 'Medium'
      ),
      'marquee' => array(
        'label' => 'Large'
      )
    );
    return $sizes;
  }

  function setSrc($src=null) {
    if (!$this->img_id) {$this->img_id = get_post_thumbnail_id();}
    $full = wp_get_attachment_image_url($this->img_id,'full');
    $this->src = $full;
  }

  protected function setClasses() {
    if ($this->size) {
      $this->imgClass = 'img-' . $this->size;
    }
    $this->imgClass .= ' ' . $this->class;
  }

  function build() {
    $this->setSrc();
    $this->setClasses();
    return "
      <img class='$this->imgClass' src='$this->src' bp-src='' />
    ";
  }

}
