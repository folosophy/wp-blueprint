<?php

namespace Blueprint\Part\Template;
use \Blueprint\Part as part;

// https://codex.wordpress.org/Function_Reference/register_post_type#Arguments

class Single extends part\Template {

  protected $article;
  protected $body;
  protected $category;
  protected $articleHeader;
  protected $hero;
  protected $postHeader;
  protected $postContent;
  protected $postMeta;
  protected $postType;
  protected $postTypeObject;
  protected $postTypeObjectLabels;
  protected $recentPosts;
  protected $sidebar;
  protected $tags;
  protected $title;

  function init() {
    parent::init();
    $this->postTypeObject = get_post_type_object($this->postType);
    bp_log_post();
  }

//   function buildPostHeader() {
//     $header = $this->getPostHeader();
//     if ($header->defaultBuild !== false) {
//       $header
//         ->insertPartBefore($this->getCategory())
//         ->insertPartAfter($this->getTitle());
//       $this->buildPostMeta();
//     }
//     $this->getBody()->addPart($header);
//   }
//
//   function getCategory($format=null) {
//     if (!isset($this->category)) {$this->setCategory();}
//     switch ($format) {
//       case 'raw' : $part = $this->category; break;
//       default    :
//         $part = (new part\Part())
//           ->setTag('h4')
//           ->setClass('post-header__category')
//           ->addPart()
//             ->setTag('a')
//             ->addHtml($this->category)
//             ->end();
//     }
//     return $part;
//   }
//
//   function getTitle() {
//    if (empty($this->title)) {$this->setTitle();}
//    return $this->title;
//   }
//
//   function getPostBody() {
//     if (!isset($this->postBody)) {$this->setPostBody();}
//     return $this->postBody;
//   }
//
//   function setCategory($category=null) {
//     if (!$category) {
//       $terms = get_the_terms(get_the_ID(),get_post_type() . '_category');
//       $cat = '';
//       if (!$terms || isset($terms->errors)) {$this->category = get_post_type();}
//       else {
//         foreach ($terms as $i => $term) {
//           if ($i < count($terms) - 1) {$this->category .= ' / ';}
//           $this->category .= $term->name;
//         }
//       }
//     } else {
//       $this->category = $category;
//     }
//     $this->category = ucwords(str_replace('_',' ',$this->category));
//   }
//
//   function setFeaturedMedia() {
//     $this->featuredMedia = (new part\Part());
//     $this->featuredMedia
//       ->setClass('post-ft-media')
//       ->addImage(null,true)
//         ->setCrop(true)
//         ->setClass('post-ft-img')
//         ->getImg();
//     // TODO: video, etc
//   }
//
//   function setHero($name=null) {
//     parent::setHero();
//     $this->getHero()
//       ->getHeroContent()
//         ->setHeadline(false);
//   }

  function getPostContent() {
    if (!isset($this->postContent)) {$this->setPostContent();}
    return $this->postContent;
  }

  function getPostHeader() {
    if (!isset($this->postHeader)) {$this->setPostHeader();}
    return $this->postHeader;
  }
//
//   function getPostMeta() {
//     if (!isset($this->postMeta)) {$this->setPostMeta();}
//     return $this->postMeta;
//   }

  function getRecentPosts() {
    if (!isset($this->recentPosts)) {$this->setRecentPosts();}
    return $this->recentPosts;
  }

//   function getPostSidebar() {
//     if (!isset($this->sidebar)) {$this->setPostSidebar();}
//     return $this->sidebar;
//   }
//
//   function setPostBody() {
//     $this->postBody = (new part\Part())
//       ->setClass('post-body');
//     return $this;
//   }

  function setPostContent() {
    $this->postContent = (new part\Part())
      ->addClass('post-content');
  }

  function setPostHeader() {
    $this->postHeader = (new part\Part())
      ->setTag('header')
      ->setClass('post-header');
  }
//
//   function setPostMeta() {
//     $this->postMeta = (new part\Part())
//       ->setClass('post-header__meta');
//   }

  function setRecentPosts() {
    $headline = 'Recent ' . ucwords(get_post_type());
    $this->recentPosts = (new part\Section('recent_posts'))
      ->setMargin('vertical');

    $posts = $this->recentPosts
      ->addContainer()
        ->addClass('post__recent-posts');

    $recent_posts_label =
      $this->postTypeObject->labels->recent_posts ??
      'Recent ' . $this->postTypeObject->label;

    $posts->addPart()
      ->setClass('headline-primary')
      ->setTag('h2')
      ->addPart()
        ->setTag('span')
        ->setClass('headline-primary__inner')
        ->addHtml($recent_posts_label);

    $post_grid = (new part\PostGrid())
      ->setPostType()
      ->setArg('post__not_in',array(get_the_ID()))
      ->setArg('orderby','rand')
      ->setArg('posts_per_page',bp_var('recent_posts_numberposts',3));
    $this->recent_posts_grid = $post_grid;

    $posts->insertPartAfter($post_grid);

  }

// function setPostSidebar() {
//   $this->sidebar = (new part\Part())
//     ->setClass('post__sidebar');
//   $this->sidebar->addHtml('test');
//   return $this;
// }
//
//   function setTitle() {
//     $this->title = (new part\Part())
//       ->setTag('h1')
//       ->setClass('post-title post-header__title')
//       ->addPart()
//         ->setTag('span')
//         ->addHtml(get_the_title())
//         ->end();
//   }
//
//   function buildPostBody() {
//     //$this->buildPostSidebar();
//     $this->buildPostContent();
//     $body = $this->getPostBody();
//     $body->insertPartBefore($this->getPostContent());
//     $body->insertPartAfter($this->getRecentPosts());
//     $this->body->insertPartAfter($this->getPostBody());
//   }
//
//   function buildPostContent() {
//     $content = $this->getPostContent();
//     if ($content->defaultBuild !== false) {
//       if (get_the_content()) {
//         $content = apply_filters('the_content',get_the_content());
//         $this->getPostContent()->addHtml($content);
//       } else {
//         $no_content = $this->postTypeObject->labels->no_content ?? 'More info coming soon!';
//         $this->getPostContent()->addHtml("<p class='center'>$no_content</p>");
//       }
//     }
//   }
//
//   function buildBody() {
//     parent::buildBody();
//     $this->buildPostHeader();
//     $this->buildPostBody();
//   }
//
//   protected function buildPostMeta() {
//     $this->getPostHeader()->insertPartAfter($this->getPostMeta());
//   }
//
//   protected function buildPostSidebar() {
//     $this->getPostBody()->insertPartBefore($this->getPostSidebar());
//   }

}
