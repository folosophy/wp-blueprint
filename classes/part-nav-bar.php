<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class NavBar extends Part {

  protected $menuItems;
  protected $social;

  function __construct() {
  }

  function addMenuItem($label,$link=null) {
    if (is_int($link)) {$link = get_the_permalink($link);}
    $item = "
      <a class='nav-bar__menu-item' href='$link'>
        $label
      </a>
    ";
    $this->menuItems .= $item;
    return $this;
  }

  function addSocial() {
    $accounts = get_field('main_social','option');
    if (!$accounts) {return $this;}
    $items = '';
    if (!$accounts) {return $this;}
    foreach ($accounts as $account) {
      $platform = $account['platform'];
      $iconClass = 'icon-social-' . $platform;
      $icon = bp_get_theme_icon('social-' . $platform,'nav-bar__social-icon-container');
      $link = $account['link'];
      $items .= "
        <a href='$link' class='nav-bar__social-icon'>$icon</a>
      ";
    }
    $this->social = "
      <div class='nav-bar__social'>
        $items
      </div>
    ";
    return $this;
  }

  function endNavBar() {
    return $this->end();
  }

  function build() {
    $this->buildParts();
    return "
      <div class='nav-bar $this->class'>
        <div class='nav-bar__menu'>
          $this->menuItems
        </div>
        $this->social
      </div>
    ";
  }

}
