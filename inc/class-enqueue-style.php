<?php

namespace Blueprint\Enqueue;

class Style extends Enqueue {

  function enqueue() {
    parent::enqueue();
    wp_enqueue_style(
      $this->name,
      $this->src,
      $this->dependencies,
      $this->version,
      $this->footer
    );
  }

  function setType() {
    $this->type = 'css';
  }

}
