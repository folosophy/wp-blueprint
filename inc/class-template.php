<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;

class Template {

  use part\Builder;

  protected $head;
  protected $body;
  protected $hero;
  protected $intro;
  protected $postType;

  function __construct() {
    $this->head = new part\Head();
    $this->postType = get_post_type();
    if (method_exists($this,'init')) {$this->init();}
  }

  function render() {
    $this->head->render();
    get_header();
    $this->renderBody();
    get_footer();
  }

  protected function renderBody() {
    wp_reset_query();
    if ($this->hero)  {$this->hero->render();}
    if ($this->intro) {$this->intro->render();}
    echo $this->body;
    echo $this->buildParts();
  }

  protected function getFooter() {
    $footer = get_template_part('parts/footer');
    echo "
      </body>
      </html>
    ";
  }

  protected function getTemplate($base,$part) {
    ob_start();
    get_template_part("parts/$base",$part);
    return ob_get_clean();
  }

}
