<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class NavMain {

  use bp\Chain;

  protected $logos;
  protected $menu;
  protected $menuButton;
  protected $menuItems;
  protected $navBar;
  protected $navClass;
  protected $brand;
  protected $button;
  protected $name;
  protected $social;
  protected $type = 'main';

  function __construct() {
    $this->navClass = 'nav-' . $this->type;
    $this->setName();
  }

  function addButton($label,$link) {
    $this->button = "
      <li class='menu-main__item'>
        <a class='menu-main__button'>$label</a>
        <div class='menu-main__item__title menu-main__button__title'>
          $label
        </div>
      </li>
    ";
    return $this;
  }

  function addMenuItems($items) {
    foreach ($items as $item) {
      if (is_int($item)) {$item = get_post($item);}
      elseif (is_string($item)) {$item  = get_page_by_path($item);}
      $this->menuItems .= "
        <li class='menu-main__item'>
          <div class='menu-main__item__title'>
            $item->post_title
          </div>
        </li>
      ";
    }
    return $this;
  }

  function setName($name=null) {
    if (!$name) {$name = \get_bloginfo('name');}
    $this->name = "<div class='nav-main__name'>$name</div>";
    return $this;
  }

  function setBrand() {
    $home_link = get_bloginfo('url');
    $this->brand = "
      <a class='nav-main__brand' href='$home_link'>
        $this->logos
      </a>
    ";
    return $this;
  }

  function addLogo($file_name) {
    // TODO: check for for png, etc
    $logo = \bp_get_theme_img('logo-inline.svg','nav-main__logo');
    $this->logos = $logo . $this->brand;
    return $this;
  }

  // TODO: create class or function for generating social
  function addSocial() {
    $accounts = get_field('main_social','option');
    if (!$accounts) {return $this;}
    $items = '';
    if (!$accounts) {return $this;}
    foreach ($accounts as $account) {
      $platform = $account['platform'];
      $iconClass = 'icon-social-' . $platform;
      $icon = bp_get_theme_icon('social-' . $platform,'nav-main__social-icon-container');
      $link = $account['link'];
      $items .= "
        <a href='$link' class='nav-main__social-icon'>$icon</a>
      ";
    }
    $this->social = "
      <div class='nav-bar__social'>
        $items
      </div>
    ";
    return $this;
  }

  function build() {
    $this->setBrand();
    return "
      $this->navBar
      <nav class='$this->navClass'>

        <div class='nav-main__wrap'>
          $this->brand

          <div class='menu-mobile'>
            <ul class='menu-main'>
              $this->menuItems
              $this->button
            </ul>
            <div class='menu-mobile__exit'></div>
          </div>

          $this->social

          <div class='menu-main__toggle'>
            <span class='menu-main__toggle__label'>MENU</span>
            <div class='menu-main__toggle__icon'>
              <div class='menu-main__toggle__top'></div>
              <div class='menu-main__toggle__mid'></div>
              <div class='menu-main__toggle__bot'></div>
            </div>
          </div>

        </div>
      </nav>
    ";
  }

}
