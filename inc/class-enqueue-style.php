<?php

namespace Blueprint;

class EnqueueStyle extends Enqueue {

  function enqueue() {
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
