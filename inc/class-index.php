<?php

namespace Blueprint;

class Index {

  protected $head;
  protected $postType;

  function __construct() {
    $this->head = new Part\Head();
    $this->postType = get_post_type();
  }

  function render() {
    $this->head->render();
    get_header();
    $this->getBody();
    get_footer();
  }

  protected function getFooter() {
    $footer = get_template_part('parts/footer');
    echo "
      </body>
      </html>
    ";
  }

  protected function getBody() {
    // TODO: mimic get_template_part, if null, then use BP class
    if (is_front_page()) {get_template_part('parts/page-home');}
    elseif (is_single()) {
      while (have_posts()) : the_post();
        $this->hero->render();
        get_template_part('parts/single-' . $this->postType);
      endwhile;
    }
  }

}
