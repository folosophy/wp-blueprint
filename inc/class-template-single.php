<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;

// https://codex.wordpress.org/Function_Reference/register_post_type#Arguments

class Single extends Template {

  protected $article;
  protected $body;
  protected $category;
  protected $postType;
  protected $postTypeObject;
  protected $postTypeObjectLabels;
  protected $recentPosts;
  protected $tags;
  protected $title;

  function init() {
    \bp_log_post();
    $this->article = apply_filters('the_content',get_the_content());
    $this->postType = get_post_type();
    $this->postTypeObject = get_post_type_object($this->postType);
    $this->postTypeObjectLabels = $this->postTypeObject->labels;
    $title = get_the_title();
    $this->title = "<h1 class='center'>$title</h1>";
    $this->setCategory();
    $this->addRecentPosts();

  }

  function setCategory() {
    $category = get_the_category();
    if ($category) {$name = $category[0]->name;}
    else {
      // TODO: write function to get post type category (ex. "genre")
      $category = wp_get_post_terms(get_the_ID(),'event_category');
      if ($category) {$name = $category[0]->name;}
    }
    if (!isset($name)){$name = get_post_type();}
    // TODO: change sub headline to archive categorylink
    $this->category = "
      <h4 class='center'><span class='link-text'>$name</span></h4>
    ";
  }

  function addRecentPosts() {
    $posts = (new part\PostGrid())
      ->setPostType()
      ->setCols(bp_var('recent_posts_numberposts',3))
      ->setNumberPosts(bp_var('recent_posts_numberposts',3))
      ->build();
    $headline = 'Recent ' . $this->postTypeObject->labels->name;
    if (isset($this->postTypeObject->labels->recent_title)) {
      $headline = $this->postTypeObject->labels->recent_title;
    }
    $this->recentPosts = "
      <section class='recent-posts'>
        <div class='wrap-main'>
          <h2 class='center'><span class='headline-primary'>$headline</span></h2>
          $posts
        </div>
      </section>
    ";
  }

  protected function setTags() {
    $tags = get_the_tags();
    if ($tags) {
      $els = '';
      foreach ($tags as $tag) {
        $els .= "<div class='tag'>$tag->name</div>";
      }
      $this->tags .= "
        <div class='tags'>
          $els
        </div>
      ";
    }
  }

  function setBody() {
    $hero = $this->getTemplate('hero','single');
    $article = "
      $this->category
      $this->title
      $this->article
      $this->tags
    ";
    $article_body = (new part\Section('article-body'))
      ->addHtml($hero)
      ->addWrap('blog')
        ->addHtml($article)
        ->end()
      ->build();
    $this->body = "
      $article_body
      $this->recentPosts
    ";
  }

  function render() {
    $this->setBody();
    parent::render();
  }

}
