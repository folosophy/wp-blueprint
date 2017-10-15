<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class NavBar extends Part {

  protected $menuItems;
  protected $social;

  function __construct() {
  }

  function addMenuItem($label,$link=null) {
    $item = "
      <div class='nav-bar__menu-item'>
        $label
      </div>
    ";
    $this->menuItems .= $item;
    return $this;
  }

  function addSocial() {
    $accounts = \bp_get_social();
    $items = '';
    if (!$accounts) {return $this;}
    foreach ($accounts as $account) {
      $platform = $account['platform'];
      $iconClass = 'icon-social-' . $platform;
      $items .= bp_get_theme_icon('social-' . $platform,'nav-bar__social-icon');
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
    return "
      <div class='nav-bar'>
        <div class='nav-bar__menu'>
          $this->menuItems
          $this->social
        </div>
      </div>
    ";
  }

}
