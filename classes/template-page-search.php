<?php

namespace Blueprint\Template\Page;
use \Blueprint\Template\Page as Page;
use \Blueprint\Part as part;

class Search extends Page {

  protected $grid;



  // protected $args;
  // protected $query;
  // protected $results;
  // protected $totalPosts;
  //
  // protected function init() {
  //   parent::init();
  //   $this->setId('template-search');
  // }
  //
  // // TODO: add to part?
  // function setArg($key,$val) {
  //   if (!is_array($this->args)) {$this->args = array();}
  //   $this->args[$key] = $val;
  //   return $this;
  // }
  //
  // function setArgs($args=null) {
  //   if (!is_array($this->args)) {$this->args = array();}
  //   if (!is_array($args)) {wp_die('setArgs expects arrray');}
  //   $this->args = $args;
  //   if (!isset($this->args['s'])) {
  //     $this->args['s'] = $_GET['q'];
  //   }
  //   return $this;
  // }
  //
  // protected function setQuery() {
  //   // Total posts
  //   // TODO: Limit max number of searched posts?
  //   if (!$this->args) {$this->setArgs();}
  //   $this->query = new \WP_Query($this->args);
  //   $this->totalPosts = $this->query->found_posts;
  // }
  //
  // function setResults() {
  //   // $this->args =
  //   $this->results = (new part\Part())
  //     ->setTag('section')
  //     ->setId('search-results');
  //   $this->results
  //     ->addWrap()
  //       ->addPostGrid('search-results',true)
  //         ->addClass('search-page__results')
  //         ->setArgs($this->args);
  //   if (
  //     $this->query->post_count <= $this->query->found_posts
  //     && $this->query->found_posts > 0
  //   ) {
  //     $this->results
  //       ->addWrap()
  //         ->addClass('center')
  //         ->addButton('load-more-posts',true)
  //           ->setLabel('Load More')
  //           ->addClass('load-more-posts')
  //           ->setLink(false);
  //   }
  //   return $this->results;
  // }
  //
  // protected function build() {
  //   parent::build();
  //   // $this->setQuery();
  //   // if (!$this->results) {$this->setResults();}
  //   $this
  //     ->addWrap('search-form')
  //       ->addForm()
  //         ->addClass('form-search')
  //         ->addSearchField('search',true)
  //           ->getFormElement()
  //             ->setAttr('value',$this->args['s'])
  //             ->addClass('page-search__search search-bar');
  //
  //   if ($this->totalPosts > 0) {$exclaim = 'Nice!'; $num = $this->totalPosts;}
  //   else {$exclaim = 'Bummer!'; $num = 'No';}
  //
  //   $this->addHeadline("$exclaim <span class='post-count'>$num</span> Results Found.",true)
  //     ->setTag('h4')
  //     ->addClass('center h4-light');
  //   $this->addPart($this->results);
  // }

}

namespace Blueprint\Part;
