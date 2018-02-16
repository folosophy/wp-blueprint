<?php

namespace Blueprint\Enqueue;

class GoogleFonts {

  private $families;

  function __construct($families) {
    $this->families = $families;
    add_action('wp_enqueue_scripts',array($this,'enqueue'));
  }

  function enqueue() {
    $url = "https://fonts.googleapis.com/css?family=$this->families";
    wp_enqueue_style('bp_google_fonts',$url);
  }

}
