<?php

use Blueprint as Bp;
use Blueprint\Part\Image as Image;

function bp_get_img($class=null,$size=null,$img_id=null) {
  return (new Image())
    ->setArgs(
        array(
          'class' => $class,
          'img_id' => $img_id,
          'size' => $size
        )
      )
    ->build();
}

function bp_get_theme_img($path,$class) {
  $url = get_template_directory_uri() . '/assets/img/' . $path;
  return "<img class='$class ps-lazy ps-unloaded' src='$url' ps-src='$url' />";
}

function bp_get_theme_icon($path,$class) {
  $url = get_template_directory_uri() . '/assets/img/icon-' . $path . '.svg';
  return "<img class='$class ps-lazy ps-unloaded' src='$url' ps-src='$url' />";
}

function bp_get_avatar($user_id=null,$class=null) {
  $url = get_avatar_url($user_id,array('default'=>'mystery'));
  $img = new Image();
  if ($class) {$img->setClass($class);}
  $img->setSrc($url);
  return $img->build();
}
