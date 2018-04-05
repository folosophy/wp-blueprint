<?php

use Blueprint\Part as part;

// function bp_image_shortcode($args) {
//   return (new Bp\Media\Image())
//     ->setArgs($args)
//     ->build();
// } add_shortcode('bp-image','bp_image_shortcode');

function bp_button($atts) {

  $label = $atts['label'] ?? null;
  $button = (new part\Button($label));
  if (isset($atts['align'])) {
    $el = (new part\Part())
      ->addClass($atts['align']);
      $el->addPart($button);
  } else {
    $el = $button;
  }

  if (isset($atts['link'])) {
    $button->setLink($atts['link']);
  }

  return $el->build();

} add_shortcode('bp_button','bp_button');

function bp_video_shortcode($atts) {

  $iframe = (new part\Part())
    ->addClass('video-temp');

    $iframe->addVideo(null,true)
      ->setVideoKey($atts['key']);

  return $iframe->build();

} add_shortcode('bp_video','bp_video_shortcode');
