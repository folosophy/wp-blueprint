<?php

// Store Main Pages

$main_pages = array(6,8,12,10,14);

$posts = get_posts(array('post_type'=>'page','post__in'=>$main_pages));
$main_pages = array();

foreach ($posts as $post) {
  $children = get_children(array(
    'post_parent'=>$post->ID,
    'numberposts'=>-1,
    'post_type'=>'page'
  ));
  if ($children) {
    $post->children = $children;
  }
  array_push($main_pages,$post);
}

$GLOBALS['bp']['cache']['main_pages'] = $main_pages;

function bp_get_main_pages() {
  return $GLOBALS['bp']['cache']['main_pages'];
}
