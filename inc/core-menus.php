<?php

function bp_get_menu($id) {

  $items = wp_get_nav_menu_items($id);
  $items_sorted = array();

  $parents = array_filter($items,function($item) {
    $parent = $item->menu_item_parent;
    if ($parent == 0) {return true;}
  });

  foreach ($parents as $parent) {

    $kids = array();

    foreach ($items as $kid) {
      if ($kid->menu_item_parent == $parent->ID) {
        array_push($kids,$kid);
      }
    }

    if (!empty($kids)) {$parent->sub_menu = $kids;}
    array_push($items_sorted,$parent);

  }

  return $items_sorted;

}
