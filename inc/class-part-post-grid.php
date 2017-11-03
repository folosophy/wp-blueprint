<?php

namespace Blueprint\Part;
use Blueprint as bp;

class PostGrid extends Grid {

  protected $args;
  protected $numPosts;
  protected $postType = 'post';
  protected $itemBuilder;

  protected function init() {
    $this->setCols(bp_var('post_grid_columns',3));
    $this->setArgs();
    $this->setNotIn();
  }

  function setArgs() {
    if (!$this->numPosts) {$this->numPosts = $this->cols;}
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
    if (!$ids) {$ids = bp_get_post_log();}
    if ($ids) {$this->args['post__not_in'] = $ids;}
    $this->args['post__not_in'] = $ids;
    return $this;
  }

  function setNumberPosts($num=null) {
    if (!$num || !is_int($num)) {$num = $this->cols;}
    $this->args['numberposts'] = $num;
    return $this;
  }

  function setOffset($offset=null) {
    if ($offset) {
      $this->args['offset'] = $offset;
    }
    return $this;
  }

  function setPostType($type=null) {
    if (!$type) {$type = get_post_type();}
    $this->args['post_type'] = $type;
    return $this;
  }

  function build() {
    $this->setItems();
    return parent::build();
  }

}
