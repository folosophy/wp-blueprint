<?php

namespace Blueprint\Part;

class Single {

  function render() {
    $this->getHeader();
    $this->loop();
    $this->getFooter();
  }

  protected function loop() {
    while (have_posts()) : the_post();
      $post_type = get_post_type();
      get_template_part('parts/body-' . $post_type);
    endwhile;
  }

  private function getHeader() {
    get_header();
  }

  private function getFooter() {
    get_footer();
  }

}
