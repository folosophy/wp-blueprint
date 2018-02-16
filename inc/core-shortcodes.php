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
    $el = $button;
    $button = (new part\Part())
      ->addClass($atts['align']);
      $button->addPart($el);
  }

  return $button->build();

} add_shortcode('bp_button','bp_button');
