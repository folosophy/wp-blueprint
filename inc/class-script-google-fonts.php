<?php

namespace Blueprint\Script;

class GoogleFonts {

  private $url;

  public static function enqueue($url) {
    $this->url = $url;
    wp_enqueue_style('bp_google_fonts',$this->url);
  }

}
