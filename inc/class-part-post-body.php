<?php

namespace Blueprint\Part;

class PostBody extends Part {

  protected $content;
  protected $postMeta;

  function __construct() {
    parent::__construct('postbody');
    $this->setContent();
    $this->setPostMeta();
  }

  protected function build() {
    return "
      <section>
        <div class='wrap-main'>
          <div class='post-body'>
            $this->postMeta
            $this->content
          </div>
        </div>
      </section>
    ";
  }

  protected function setContent($content=null) {
    if (!$content) {
      $content = apply_filters('the_content',get_the_content());
    }
    $this->content = $content;
    return $this;
  }

  protected function setPostMeta($meta=null) {
    if (!$meta) {
      $meta = new PostMeta();
      $this->postMeta = $meta->build();
    }
  }

}
