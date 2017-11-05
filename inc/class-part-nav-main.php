<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class NavMain {

  use bp\Chain;

  protected $logos;
  protected $menu;
  protected $menuButton;
  protected $menuItems;
  protected $menuMain;
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

  function setMainMenu() {
    if (!isset($this->menuMain)) {
      $this->menuMain = (new MenuMain('menu-main',$this));
      return $this->menuMain;
    } else {wp_die('Main Menu already set.');}
  }

  function addMenuItems($items) {
    foreach ($items as $item) {
      if (is_int($item)) {$item = get_post($item);}
      elseif (is_string($item)) {$item  = get_page_by_path($item);}
      $children = get_posts(array('post_parent'=>10,'post_type'=>'page'));
      if ($children) {}
      // Build item
      $menuItem = "
        <li class='menu-main__item'>
          <div class='menu-main__item__title'>
            $item->post_title
          </div>
        </li>
      ";
    }
    return $this;
  }

  function addMainPages() {

  }

  // TODO: Create menu item and

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
    // Main Menu
    if (!$this->menuMain) {
      $this->setMainMenu();
    }
    $menuMain = $this->menuMain->build();
    return "
      $this->navBar
      <nav class='$this->navClass'>

        <div class='nav-main__wrap'>
          $this->brand
          $menuMain
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

class SubMenu {



}

class MenuMain extends Part {

  protected $button;
  protected $items;

  function init() {
    $this->setClass('menu-mobile');
    $this->addMainPages();
  }

  function addMenuButton($label,$link) {
    if (!isset($this->button)) {
      $this->button = "
        <a class='menu-main__item' href='$link'>
          <div class='menu-main__button'>$label</div>
          <div class='menu-main__item__title menu-main__button__title'>
            $label
          </div>
        </a>
      ";
    } else {wp_die('Only one menu button allowed.');}
    return $this;
  }

  function addMainPages() {
    $pages = bp_get_main_pages();
    foreach ($pages as $item) {
      // Build item
      $link = get_the_permalink($item->ID);
      $menuItem = "
        <a class='menu-main__item' href='$link'>
          <div class='menu-main__item__title'>
            $item->post_title
          </div>
        </a>
      ";
      $this->items .= $menuItem;
    }
    return $this;
  }

  function buildInit() {
    if ($this->button) {$this->items .= $this->button;}
    $this->part = "
      <div class='menu-main'>
        $this->items
      </div>
      <div class='menu-mobile__exit'></div>
    ";
  }

}
