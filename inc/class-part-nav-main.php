<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class NavMain extends Part {

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

  function init() {
    $this->navClass = 'nav-' . $this->type;
  }

  function addMenuButton($label,$link) {
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

  function setMenu() {
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
    if ($name === false) {return $this;}
    elseif ($name == null) {$name = get_bloginfo('name');}
    $this->name = "<div class='nav-main__name'>$name</div>";
    return $this;
  }

  function setBrand() {
    $home_link = get_bloginfo('url');
    if (!$this->logos) {$this->setName();}
    $this->brand = "
      <a class='nav-main__brand' href='$home_link'>
        $this->name
        $this->logos
      </a>
    ";
    return $this;
  }

  function addLogo($file) {
    // TODO: check for for png, etc
    $logo = \bp_get_theme_img($file,'nav-main__logo');
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
      $icon = bp_get_theme_img('icon-social-' . $platform . '-white.svg','nav-main__social-icon');
      $link = $account['link'];
      $items .= "
        <a href='$link' class='nav-main__social-icon-container'>$icon</a>
      ";
    }
    $this->social = "
      <div class='nav-main__social'>
        $items
      </div>
    ";
    return $this;
  }

  function build() {
    $this->setBrand();
    // Main Menu
    if (!$this->menuMain) {
      $this->setMenu();
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

  function addMainPages($pages=null) {
    if (!$pages) {$pages = bp_var('main_pages');}
    if (!$pages) {return $this;}
    foreach ($pages as $item) {
      if (is_int($item)) {
        $item = get_post($item);
      }
      // Sub Menu
      $sub_menu = '';
      if (isset($item->children)) {
        $sub_items = '';
        foreach ($item->children as $child) {
          $link = get_permalink($child->ID);
          $sub_items .= "
            <div class='menu-main__sub-item'>
              <a class='menu-main__sub-item__title' href='$link'>
                $child->post_title
              </a>
            </div>
          ";
        }
        $sub_menu = "
          <div class='menu-main__sub-menu'>
            $sub_items
          </div>
        ";
      }
      // Build item
      $link = get_permalink($item->ID);
      $menuItem = "
        <div class='menu-main__item'>
          <a class='menu-main__item__title' href='$link'>
            $item->post_title
          </a>
          $sub_menu
        </div>
      ";
      $this->items .= $menuItem;
    }
    return $this;
  }

  function addMenuItems() {

  }

  function buildInit() {
    if (empty($this->items)) {$this->addMainPages();}
    if ($this->button) {$this->items .= $this->button;}
    $this->part = "
      <div class='menu-main'>
        $this->items
      </div>
      <div class='menu-mobile__exit'></div>
    ";
  }

}
