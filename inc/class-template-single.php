<?php

namespace Blueprint\Template;
use \Blueprint\Part as part;

// https://codex.wordpress.org/Function_Reference/register_post_type#Arguments

class Single extends \Blueprint\Template {

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

  function buildPostHeader() {
    $header = $this->getPostHeader()
      ->insertPartBefore($this->getCategory())
      ->insertPartAfter($this->getTitle());
    $this->buildPostMeta();
    $this->getBody()->addPart($header);
  }

  function getCategory($format=null) {
    if (!isset($this->category)) {$this->setCategory();}
    switch ($format) {
      case 'raw' : $part = $this->category; break;
      default    :
        $part = (new part\Part())
          ->setTag('h4')
          ->setClass('post-header__category')
          ->addPart()
            ->setTag('a')
            ->addHtml($this->category)
            ->end();
    }
    return $part;
  }

  function getTitle() {
   if (empty($this->title)) {$this->setTitle();}
   return $this->title;
  }

  function getPostBody() {
    if (!isset($this->postBody)) {$this->setPostBody();}
    return $this->postBody;
  }

  function setCategory($category=null) {
    if (!$category) {
      $terms = get_the_terms(get_the_ID(),'event_category');
      $cat = '';
      if (!$terms) {$this->category = get_post_type();}
      else {
        foreach ($terms as $i => $term) {
          if ($i < count($terms) - 1) {$this->category .= ' / ';}
          $this->category .= $term->name;
        }
      }
    } else {
      $this->category = $category;
    }
    $this->category = ucwords(str_replace('_',' ',$this->category));
  }

  function setFeaturedMedia() {
    $this->featuredMedia = (new part\Part());
    $this->featuredMedia
      ->setClass('post-ft-media')
      ->addImage(null,true)
        ->setCrop(true)
        ->setClass('post-ft-img')
        ->getImg();
    // TODO: video, etc
  }

  function setHero() {
    parent::setHero();
    $this->getHero()
      ->getContent()
        ->setHeadline(false);
  }

  function getPostContent() {
    if (!isset($this->postContent)) {$this->setPostContent();}
    return $this->postContent;
  }

  function getPostHeader() {
    if (!isset($this->postHeader)) {$this->setPostHeader();}
    return $this->postHeader;
  }

  function getPostMeta() {
    if (!isset($this->postMeta)) {$this->setPostMeta();}
    return $this->postMeta;
  }

  function getRecentPosts() {
    if (!isset($this->recentPosts)) {$this->setRecentPosts();}
    return $this->recentPosts;
  }

  function getPostSidebar() {
    if (!isset($this->sidebar)) {$this->setPostSidebar();}
    return $this->sidebar;
  }

  function setPostBody() {
    $this->postBody = (new part\Part())
      ->setClass('post-body');
    return $this;
  }

  function setPostContent() {
    $this->postContent = (new part\Part())
      ->addClass('post-content');
  }

  function setPostHeader() {
    $this->postHeader = (new part\Part())
      ->setTag('header')
      ->setClass('post-header');
  }

  function setPostMeta() {
    $this->postMeta = (new part\Part())
      ->setClass('post__meta');
  }

  function setRecentPosts() {
   $headline = 'Recent ' . ucwords(get_post_type());
    $this->recentPosts = (new part\Section('recent_posts'));

    $posts = $this->recentPosts
      ->addPart()
        ->setClass('post__recent-posts');

    $recent_posts_label =
      $this->postTypeObject->labels->recent_posts ??
      $this->postTypeObject->labels->name;

    $posts->addPart()
      ->setClass('headline-primary')
      ->setTag('h2')
      ->addPart()
        ->setTag('span')
        ->setClass('headline-primary__inner')
        ->addHtml($recent_posts_label);

    $post_grid = (new part\PostGrid())
      ->setPostType()
      ->setCols(bp_var('recent_posts_numberposts',3))
      ->setNumberPosts(bp_var('recent_posts_numberposts',3));

    $posts->insertPartAfter($post_grid);

  }

function setPostSidebar() {
  $this->sidebar = (new part\Part())
    ->setClass('post__sidebar');
  $this->sidebar->addHtml('test');
  return $this;
}

  function setTitle() {
    $this->title = (new part\Part())
      ->setTag('h2')
      ->setClass('post-title post-header__title')
      ->addPart()
        ->setTag('span')
        ->addHtml(get_the_title())
        ->end();
  }

  function buildPostBody() {
    //$this->buildPostSidebar();
    $this->buildPostContent();
    $body = $this->getPostBody();
    $body->insertPartBefore($this->getPostContent());
    $body->insertPartAfter($this->getRecentPosts());
    $this->body->insertPartAfter($this->getPostBody());
  }

  function buildPostContent() {
    if (get_the_content()) {
      $content = apply_filters('the_content',get_the_content());
      $this->getPostContent()->addHtml($content);
    } else {
      $no_content = $this->postTypeObject->labels->no_content ?? 'More info coming soon!';
      $this->getPostContent()->addHtml("<p class='center'>$no_content</p>");
    }
  }

  function buildBody() {
    parent::buildBody();
    $this->buildPostHeader();
    $this->buildPostBody();
  }

  protected function buildPostMeta() {
    $this->getPostHeader()->insertPart($this->getPostMeta());
  }

  protected function buildPostSidebar() {
    $this->getPostBody()->insertPartBefore($this->getPostSidebar());
  }

 //  function setCategory() {
 //    $category = get_the_category();
 //    if ($category) {$name = $category[0]->name;}
 //    else {
 //      // TODO: write function to get post type category (ex. "genre")
 //      $category = wp_get_post_terms(get_the_ID(),'event_category');
 //      if (is_array($category)) {$name = $category[0]->name;}
 //    }
 //    if (!isset($name)){$name = get_post_type();}
 //    // TODO: change sub headline to archive categorylink
 //    $this->category = "
 //      <h4 class='center'><span class='link-text'>$name</span></h4>
 //    ";
 //    return $category;
 //  }
 //
 //  function setPostContent() {
 //    $this->content = apply_filters('the_content',get_the_content());
 //    $content = (new part\Part())
 //      ->setId('post-content')
 //      ->addHtml($this->content);
 //    return $content;
 //  }
 //
 //  function setBody() {
 //    $header = $this->setPostHeader();
 //    $this->body = (new part\Part())
 //      ->setId('post-body');
 //    $this->addPart($this->body);
 //    $this->body->addPart($this->hero);
 //    $this->body
 //      ->addPart($header);
 //    $this->body->addPart($this->setPostContent());
 //
 //    if ($this->recentPosts !== false) {
 //        if (!$this->recentPosts) {
 //          $this->setRecentPosts();
 //        }
 //        $this->addPart($this->recentPosts);
 //      }
 //
 //
 //    return $this->body;
 //  }
 //
 //  function setPostHeader() {
 //    $header = (new part\Part())
 //      ->setId('post-header')
 //
 //      ->addHeadline("<span class='headline-primary'>" . get_the_title() . "</span>")
 //      //->addPart($this->setCategory())->end()
 //      ;
 //    $this->postHeader = $header;
 //    return $header;
 //  }
 //
 //  function setRecentPosts() {
 //   $posts = (new part\PostGrid())
 //     ->setPostType()
 //     ->setCols(bp_var('recent_posts_numberposts',3))
 //     ->setNumberPosts(bp_var('recent_posts_numberposts',3))
 //     ->build();
 //   $headline = 'Recent ' . $this->postTypeObject->labels->name;
 //   if (isset($this->postTypeObject->labels->recent_title)) {
 //     $headline = $this->postTypeObject->labels->recent_title;
 //   }
 //   $this->recentPosts = (new part\Section('recent_posts'))
 //     ->addWrap()
 //       ->addHtml("<h2 class='center'><span class='headline-primary'>$headline</span></h2>")
 //       ->addHtml($posts)
 //       ->end();
 // }

  // protected function buildInit() {
  //   parent::buildInit();
  //   if (!isset($this->body)) {$this->setBody();}
  // }









  // function init() {
  //   parent::init();
  //   $this->postType = get_post_type();
  //   $this->postTypeObject = get_post_type_object($this->postType);
  //   bp_log_post();
  //   $this->setBody();
  // }
  //
  // function buildInit() {
  //   parent::buildInit();
  //   $this->setCategory();
  //   if ($this->recentPosts !== false) {
  //     if (!$this->recentPosts) {
  //       $this->setRecentPosts();
  //     }
  //     $this->addPart($this->recentPosts);
  //   }
  // }
  //
  // function setArticleHeader() {
  //   $part = (new part\Part('article-header'));
  //   return $this->addPart($part,true,'articleHeader');
  // }
  //
  // function setBody() {
  //   $this->article = apply_filters('the_content',get_the_content());
  //   $postMeta = (new part\PostMeta());
  //   $this
  //     ->addSection('post')
  //       ->addWrap('main')
  //         ->addPart()
  //           ->setClass('post-body')
  //           //->addPart($postMeta)
  //             //->end()
  //           ->addHtml($this->article)
  //           ->end();
  // }
  //
  // function setCategory() {
  //   return null;
  //   $category = get_the_category();
  //   if ($category) {$name = $category[0]->name;}
  //   else {
  //     // TODO: write function to get post type category (ex. "genre")
  //     $category = wp_get_post_terms(get_the_ID(),'event_category');
  //     if (is_array($category)) {$name = $category[0]->name;}
  //   }
  //   if (!isset($name)){$name = get_post_type();}
  //   // TODO: change sub headline to archive categorylink
  //   $this->category = "
  //     <h4 class='center'><span class='link-text'>$name</span></h4>
  //   ";
  //   return $category;
  // }
  //
  // // function initHero() {
  // //   $hero = (new part\Hero\Single());
  // // }
  //
  // function getCategory() {
  //   return $this->category;
  // }
  //
  // function setRecentPosts() {
  //   $posts = (new part\PostGrid())
  //     ->setPostType()
  //     ->setCols(bp_var('recent_posts_numberposts',3))
  //     ->setNumberPosts(bp_var('recent_posts_numberposts',3))
  //     ->build();
  //   $headline = 'Recent ' . $this->postTypeObject->labels->name;
  //   if (isset($this->postTypeObject->labels->recent_title)) {
  //     $headline = $this->postTypeObject->labels->recent_title;
  //   }
  //   $this->recentPosts = (new part\Section('recent_posts'))
  //     ->addWrap()
  //       ->addHtml("<h2 class='center headline-primary'>$headline</h2>")
  //       ->addHtml($posts)
  //       ->end();
  // }





  // protected $article;
  // protected $body;
  // protected $category;
  // protected $postType;
  // protected $postTypeObject;
  // protected $postTypeObjectLabels;
  // protected $recentPosts;
  // protected $tags;
  // protected $title;
  //
  // function init() {
  //   \bp_log_post();
  //   $this->article = apply_filters('the_content',get_the_content());
  //   $this->postType = get_post_type();
  //   $this->postTypeObject = get_post_type_object($this->postType);
  //   $this->postTypeObjectLabels = $this->postTypeObject->labels;
  //   $title = get_the_title();
  //   $this->title = "<h1 class='center'>$title</h1>";
  //   $this->setCategory();
  //   $this->addRecentPosts();
  //
  // }
  //
  // function setCategory() {
  //   $category = get_the_category();
  //   if ($category) {$name = $category[0]->name;}
  //   else {
  //     // TODO: write function to get post type category (ex. "genre")
  //     $category = wp_get_post_terms(get_the_ID(),'event_category');
  //     if (is_array($category)) {$name = $category[0]->name;}
  //   }
  //   if (!isset($name)){$name = $this->postTypeObjectLabels->singular_name;}
  //   // TODO: change sub headline to archive categorylink
  //   $this->category = "
  //     <h4 class='center'><span class='link-text'>$name</span></h4>
  //   ";
  // }
  //
  // function addRecentPosts() {
  //   $posts = (new part\PostGrid())
  //     ->setPostType()
  //     ->setCols(bp_var('recent_posts_numberposts',3))
  //     ->setNumberPosts(bp_var('recent_posts_numberposts',3))
  //     ->build();
  //   $headline = 'Recent ' . $this->postTypeObject->labels->name;
  //   if (isset($this->postTypeObject->labels->recent_title)) {
  //     $headline = $this->postTypeObject->labels->recent_title;
  //   }
  //   $this->recentPosts = "
  //     <section class='recent-posts'>
  //       <div class='wrap-main'>
  //         <h2 class='center'><span class='headline-primary'>$headline</span></h2>
  //         $posts
  //       </div>
  //     </section>
  //   ";
  // }
  //
  // protected function setTags() {
  //   $tags = get_the_tags();
  //   if ($tags) {
  //     $els = '';
  //     foreach ($tags as $tag) {
  //       $els .= "<div class='tag'>$tag->name</div>";
  //     }
  //     $this->tags .= "
  //       <div class='tags'>
  //         $els
  //       </div>
  //     ";
  //   }
  // }
  //
  // function setBody() {
  //   $hero = $this->getPart('hero-single',$this->postType);
  //   $article = "
  //     $this->category
  //     $this->title
  //     $this->article
  //     $this->tags
  //   ";
  //   $article_body = (new part\Section('article-body'))
  //     ->addHtml($hero)
  //     ->addWrap('blog')
  //       ->addHtml($article)
  //       ->end()
  //     ->build();
  //   $this->body = "
  //     $article_body
  //     $this->recentPosts
  //   ";
  // }
  //
  // function buildInit() {
  //   $this->setBody();
  //   $this->addPart($this->body);
  // }

}
