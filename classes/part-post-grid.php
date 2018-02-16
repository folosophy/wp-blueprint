<?php

namespace Blueprint\Part;
use Blueprint as bp;

class PostGrid extends Grid {

  protected $args = array();
  protected $card;
  protected $numPosts;
  protected $postType = 'post';
  protected $query;
  protected $itemBuilder;

  protected function init() {
    parent::init();
    $this->setLoadMore(false);
  }

  function getArg($arg) {
    $args = $this->getArgs();
    return $args[$arg] ?? false;
  }

  function getArgs() {
    if (!isset($this->args)) {$this->setArgs();}
    return $this->args;
  }

  function getCard() {
    return $this->card;
  }

  function getQuery() {
    if (!isset($this->query)) {$this->setQuery();}
    return $this->query;
  }

  function setArg($key,$val) {
    $this->args[$key] = $val;
    return $this;
  }

  function setArgs($args=null) {
    if (!is_array($args)) {$args = array();}
    $this->args = $args;
  }

  function setCard($name=null) {
    $this->card = $name;
    return $this;
  }

  function setQuery() {
    $this->args['post_status'] = 'publish';
    $args = $this->args;
    if (!isset($this->args['post__not_in'])) {$this->setNotIn();}
    $this->args = $args;
    $this->query = new \WP_Query($args);
  }

  function setLoadMore($bool) {
    $this->loadMore = (bool) $bool;
    if ($bool) {
      $this->setQuery();
    } else {
      $this->args['max_num_pages'] = 1;
    }
    return $this;
  }

  function setMeta($key,$val) {
    $this->args['meta_key'] = $key;
    $this->args['meta_value'] = $val;
    return $this;
  }

  function prepareItems() {
    $query = $this->getQuery();

    $posts = $query->posts; global $post;

    foreach ($posts as $post) : setup_postdata($post);

      $card = $this->card ?? get_post_type();
      $item = bp_get_part('card',$card);
      if (!$item) {diedump('No card found');}
      $this->addItem($item);

    endforeach; wp_reset_postdata();

    $this->getGrid()->insertPart($this->items);

  }

  function setNotIn($ids = null) {
    if (!$ids) {$ids = bp_var('post_log');}
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

  function isArchive($bool=true) {
    if ($bool == true) {
      add_action('wp_enqueue_scripts',array($this,'localizeLoadMore'));
      $this->setArg('posts_per_page',9);
      $this->setLoadMore(true);
    }
    return $this;
  }

  function localizeLoadMore() {
    $query = $this->query;
    wp_localize_script('bp_lazy_loader_script','archive',array('query_vars'=>$query->query_vars));
  }

  protected function prepareLoadMore() {
    if ($this->loadMore) {
      $this->addPart()
        ->setClass('center')
        ->addPart()
          ->addHtml('Load More')
          ->setClass('load-more-posts')
          ->setAttr('data-label','Load More');
    }
  }

  function buildInit() {
    $this->prepareItems();
    $this->prepareLoadMore();
  }

}
