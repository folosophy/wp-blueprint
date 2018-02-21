<?php

namespace Blueprint\Part;

class Image extends Part {

  use MediaBuilder;

  protected $size;
  protected $class;
  protected $crop;
  protected $img;
  protected $imgId;
  protected $post;
  protected $src;
  protected $srcLowRes;

  function init() {
    if ($this->name) {$this->setSrc($this->name);}
    $this->setCrop(false);
  }

  static function getUrl($size,$img_id) {
    // TODO: sizes array and theme filter
    $url = wp_get_attachment_image_src($img_id,$size);
    $url = $url[0];
    return $url;
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

  // protected function getSrcset($img_id) {
  //   // TODO: check for valid size
  //   $set   = '';
  //   $sizes = array(
  //     'medium' => '1000',
  //     'large',
  //     'hero'
  //   );
  //
  // }

  function isBg($is_bg) {
    if ($is_bg) {$this->addClass('img-bg');}
    return $this;
  }

  protected function makeSrcset($img_id,$sizes=null) {
    // TODO: more accurate sizing
    $set = '';
    $sizes = array(
      'medium' => '80w',
      'large'  => '1200w'
    );
    foreach ($sizes as $size => $width) {
      $url = wp_get_attachment_image_src($img_id,$size);
      $url = $url[0];
      if ($url) {$set .= "$url $width,";}
    }
    return $set;
  }

  function setImg() {
    $this->img = (new Image())
      ->setPost($this->post);
    if ($this->crop) {$this->img->setClass('img-bg');}
    return $this->img;
  }

  function setSrc($src=null) {

    if (!$src) {
      $img_id = get_field('featured_media_image',$this->post_id) ?: get_post_thumbnail_id($this->post_id);
      if ($img_id) {$src = (int) $img_id;}
    }

    if (intval($src)) {

      $srcset = $this->makeSrcset($src);
      $this->setAttr('data-srcset',$srcset);
      $this->setAttr('src',self::getUrl('lowres',$src));
      $alt =  get_post_meta($src,'_wp_attachment_image_alt',true);
      $this->getImg()->setAlt($alt);
      $this->setLazy(true);

    }
    elseif (is_string($src)) {

      $srcset = false;
      if (strpos($src,'http') !== 0) {
        $src = get_template_directory_uri() . '/assets/img/' . $src;
      }
      $this->setAttr('src',$src);

    }

    return $this;

    // if (is_int($src)) {
    //   $full = wp_get_attachment_image_url($src,'full');
    // } elseif (is_string($src)) {
    //   $full = $src;
    // } else {
    //   // Default featured image
    //   if (!$this->imgId) {
    //     $this->imgId = get_post_thumbnail_id($this->post_id);
    //   }
    //   if ($this->imgId) {
    //     $full = wp_get_attachment_image_url($this->imgId,'full');
    //   } else {
    //     $full = plugins_url() . '/wp-blueprint/' . 'assets/img/placeholder.jpg';
    //   }
    // }
    // $this->img->setAttr('src-full',$full);
    // $this->img->setAttr('src',wp_get_attachment_image_url($this->imgId,'lowres'));
    // return $this->img;

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
      if (!isset($this->atts['src']) && !isset($this->getAtts['srcset'])) {$this->setSrc();}
      if (empty($this->atts['class'])) {$this->addClass('img');}
      if ($this->lazy) {$this->addClass('lazy-unloaded lazy-media lazy-item');}
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
