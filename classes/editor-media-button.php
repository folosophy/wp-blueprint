<?php

namespace Blueprint;

class EditorMediaButton {

  protected $label;

  function __construct($label) {
    $this->label = $label;
    add_action('media_buttons',array($this,'render'));
  }

  function render() {
    echo "
     <button type='button' class='button add_media bp-add-content'>
       <span class='wp-media-buttons-icon'></span>
       $this->label
     </button>
   ";
  }

}
