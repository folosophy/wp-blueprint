<?php

namespace Blueprint;

class Index {

  protected $template;

  function __construct() {
    $this->loadTemplate();
  }

  protected function loadTemplate() {

    // TODO: mimic get_template_part, if null, then use BP class
    wp_reset_query();
    global $post;
    if (is_front_page()) {$this->setTemplate('page','home');}
    elseif (is_page()) {$this->setTemplate('page',$post->post_name);}
    elseif (is_single()) {
      $this->setTemplate('single',get_post_type());
      if (!$this->template) {
        $template = (new template\Single())
          ->render();
      }
    }


    if ($this->template) {echo $this->template;}
    else {}

  }

  protected function setTemplate($base,$part) {
    ob_start();
    get_template_part("parts/$base",$part);
    $this->template = ob_get_clean();
    return $this->template;
  }

}
