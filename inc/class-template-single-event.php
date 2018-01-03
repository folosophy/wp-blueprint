<?php

namespace Blueprint\Template\Single;
use \Blueprint\Template as template;

class Event extends template\Single {

  protected function buildPostMeta() {
    parent::buildPostMeta();
    $field = get_field('event');
    if ($field) {
      $address = $field['address'];
      $start = \DateTime::createFromFormat('Y-m-d H:i',$field['start']);
      $start_date = $start->format('D / F j') ?? null;
      $start_time = $start->format('ga') ?? null;
      $end = \DateTime::createFromFormat('Y-m-d H:i',$field['end']);
      $end_time = $end->format('ga');
      $this->getPostMeta()
        ->addHtml("
          <p class='p2'>
            $start_date<br />
            $start_time - $end_time
          </p class='p2'>
        ");
    }
  }

  function setRecentPosts() {
    parent::setRecentPosts();
    if (!$this->recentPosts) {return $this;}
    $this->recent_posts_grid
      ->setArg('meta_key','event_start')
      ->setArg('orderby','event_start');
  }

}
