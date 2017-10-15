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
    if ($this->logos) {
      $name = '';
    }
    $this->brand = "
      $this->logos
      $name
    ";
    return $this;
  }

  function addLogo($file_name) {
    // TODO: check for for png, etc
    $logo = \bp_get_theme_img('logo-inline.svg','nav-main__logo');
    $this->logos = $logo . $this->brand;
    return $this;
  }

  function build() {
    $this->setBrand();
    return "
      $this->navBar
      <nav class='$this->navClass'>
        <div class='nav-main__wrap'>
          <div class='nav-main__brand'>
            $this->brand
          </div>
          <div class='menu-mobile'>
            <ul class='menu-main'>
              $this->menuItems
              $this->button
            </ul>
          </div>
        </div>
      </nav>
    ";
  }

}
