<?php

namespace Blueprint\Template;

class Index extends Template {

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
    elseif (is_single()) {$this->setTemplate('single',$this->postType);}

    if ($this->template) {echo $this->template;}
    else {}

  }

  protected function setTemplate($base,$part) {
    ob_start();
    get_template_part("parts/$base",$part);
    $this->template = ob_get_clean();
  }

}
