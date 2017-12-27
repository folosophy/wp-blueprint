<?php

namespace Blueprint\Part;

class Image extends Part {

  use MediaBuilder;

  protected $size;
  protected $class;
  protected $crop;
  protected $img;
  protected $imgId;
  protected $src;
  protected $srcLowRes;

  function init() {
    $this->setCrop(false);
  }

  function getImg() {
    if (!isset($this->img)) {
      $this->setImg();
    }
    return $this->img;
  }

  static function getSizes($returnType=null) {
    $sizes =  array(
      'blog' => array(
        'label' => 'Medium'
      ),
      'full' => array(
        'label' => 'Full'
      ),
      'marquee' => array(
        'label' => 'Large'
      )
    );
    if ($returnType == 'key') {return array_keys($sizes);}
    else {return $sizes;}
  }

  function setImg() {
    $this->img = (new Image());
    if ($this->crop) {$this->img->setClass('img-bg');}
    return $this->img;
  }

  function setSrc($src=null) {
    if (is_int($src)) {
      $full = wp_get_attachment_image_url($src,'full');
    } elseif (is_string($src)) {
      $full = $src;
    }else {
      if (!$this->imgId) {
        $this->imgId = get_post_thumbnail_id();
      }
      if ($this->imgId) {
        $full = wp_get_attachment_image_url($this->imgId,'full');
      } else {
        $full = plugins_url() . '/wp-blueprint/' . 'assets/img/placeholder.jpg';
      }
    }
    $this->img->setAttr('src-full',$full);
    $this->img->setAttr('src',wp_get_attachment_image_url($this->imgId,'lowres'));
    return $this->img;
  }

  function setCrop($crop=false) {
    $this->crop = $crop;
    if (!$crop) {
      $this->img = $this;
      $this->setTag('img');
    } else {
      $this->setTag('div');
      $this->setImg();
    }
    return $this;
  }

  function setSize($size) {
    if (!in_array($size,self::getSizes('key'))) {wp_die('Invalid setSize size.');}
    $this->size = $size;
    // TODO: class for image or container, depending
    return $this;
  }

  function buildInit() {
    if ($this->crop == true) {
      $this->insertPartAfter($this->img);
    } else {
      if (!isset($this->atts['src-full'])) {$this->setSrc();}
      $this->addClass('ps-unloaded ps-lazy');
    }
    // if ($this->crop == true) {
    //   $this->setTag('div');
    //   $this->addClass('container-' . $this->size . ' crop-medium');
    //   $img = $this->addImage(null,true);
    // } else {
    //   $img = $this;
    // }
    // $img->setTag('img');
    // if (!$this->src) {$this->setSrc();}
    // $img->atts = array(
    //   'src' => $this->srcLowRes,
    //   'src-full' => $this->src
    // );
    //
    // $img->addClass('ps-unloaded ps-lazy');
  }

}
