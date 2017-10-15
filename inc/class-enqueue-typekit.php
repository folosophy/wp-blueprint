<?php

namespace Blueprint\Enqueue;

class Typekit {

  private $id;

  function __construct($id) {
    $this->id = $id;
    add_action('wp_enqueue_scripts',array($this,'enqueue'));
    add_action('wp_head',array($this,'render'));
  }

  function enqueue() {
    wp_enqueue_script('typekit',"//use.typekit.net/$this->id.js", array(), '1.0.0');
  }

  function render() {
    if (wp_script_is('typekit','enqueued')) {
		  echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
	  }
  }

}
