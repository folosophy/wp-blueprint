<?php

use Blueprint as Bp;

function bp_image_shortcode($args) {
  return (new Bp\Media\Image())
    ->setArgs($args)
    ->build();
} add_shortcode('bp-image','bp_image_shortcode');
