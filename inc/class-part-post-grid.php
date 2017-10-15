<?php

namespace Blueprint\Part;
use Blueprint as bp;

class PostGrid extends Grid {

  protected $args;
  protected $numPosts = 3;
  protected $postType = 'post';
  protected $itemBuilder;

  protected function init() {
    $this->setArgs();
  }

  function setArgs() {
    $args  = array(
      'post_type'   => $this->postType,
      'numberposts' => $this->numPosts
    );
    $this->args= $args;
    return $this;
  }

  function setMeta($key,$val) {
    $this->args['meta_key'] = $key;
    $this->args['meta_value'] = $val;
    return $this;
  }

  function setItemBuilder($class=null) {
    if (!$class) {$class = 'Blueprint\Part\Card';}
    $this->itemBuilder = $class;
    return $this;
  }

  function setItems($items=null) {

    if (!$items) {
      $this->setItemBuilder();
    }

    $posts = get_posts($this->args); global $post;

    foreach ($posts as $post) : setup_postdata($post);
      $card = (new Card())->build();
      $this->addItem($card);
    endforeach; wp_reset_postdata();

  }

  function setNotIn($ids = null) {
    if (!$ids) {$ids = bp\get_post_log();}
    if ($ids) {$this->args['post__not_in'] = $ids;}
    $this->args['post__not_in'] = $ids;
    return $this;
  }

  function setOffset($offset=null) {
    if ($offset) {
      $this->args['offset'] = $offset;
    }
    return $this;
  }

  function setPostType($type) {
    $this->args['post_type'] = $type;
    return $this;
  }

  function build() {
    $this->setItems();
    return parent::build();
  }

}
