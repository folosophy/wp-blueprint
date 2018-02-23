<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class NavMain extends Part {

  protected $brand;
  protected $brandLogo;
  protected $darkLogo;
  protected $lightLogo;
  protected $brandName;
  protected $button;
  protected $logos;
  protected $menu;
  protected $menuButton;
  protected $menuItems;
  protected $menuMain;
  protected $navBar;
  protected $navClass;
  protected $name;
  protected $siteName;
  protected $social;
  protected $type = 'main';

  function init() {
    $this->setTag('nav');
    $this->setClass('nav-main');
  }

  //   function addMainPages($pages=null) {
//     if (!$pages) {$pages = bp_var('main_pages');}
//     if (!$pages) {return $this;}
//     foreach ($pages as $item) {
//       if (is_int($item)) {
//         $item = get_post($item);
//       }
//       // Sub Menu
//       $sub_menu = '';
//       if (isset($item->children)) {
//         $sub_items = '';
//         foreach ($item->children as $child) {
//           $link = get_permalink($child->ID);
//           $sub_items .= "
//             <div class='menu-main__sub-item'>
//               <a class='menu-main__sub-item__title' href='$link'>
//                 $child->post_title
//               </a>
//             </div>
//           ";
//         }
//         $sub_menu = "
//           <div class='menu-main__sub-menu'>
//             $sub_items
//           </div>
//         ";
//       }
//       // Build item
//       $link = get_permalink($item->ID);
//       $menuItem = "
//         <div class='menu-main__item'>
//           <a class='menu-main__item__title' href='$link'>
//             $item->post_title
//           </a>
//           $sub_menu
//         </div>
//       ";
//       $this->items .= $menuItem;
//     }
//     return $this;
//   }

  function getBrand() {
    if (!$this->brand) {$this->setBrand();}
    return $this->brand;
  }

  function getBrandName() {
    if (!isset($this->brandName)) {$this->setBrandName();}
    return $this->brandName;
  }

  function getBrandLogo() {
    return $this->brandLogo;
  }

  function getMenu() {
    if (!isset($this->menu)) {$this->setMenu();}
    return $this->menu;
  }

  function getMobileMenu() {
    if (!isset($this->mobileMenu)) {$this->setMobileMenu();}
    return $this->mobileMenu;
  }

  function setBrand() {
    $this->brand = (new Part())
      ->setClass('nav-main__brand')
        ->setTag('a')
        ->setAttr('href',get_bloginfo('url'));
    return $this;
  }

  function setBrandName($name=null) {
    if ($name === false) {return $this;}
    if (!$name) {$name = get_bloginfo('name');}
    $this->brandName = (new Part())
      ->setClass('nav-main__brand-name')
      ->addHtml($name);
    return $this;
  }

  function setBrandLogo($file=null,$chain=false) {

    $logo  = get_template_directory() . '/assets/img/logo.svg';
    $light = get_template_directory() . '/assets/img/logo-light.svg';
    $dark  = get_template_directory() . '/assets/img/logo-dark.svg';
    $brand = $this->getBrand();

    if (file_exists($dark)) {
      $src = get_template_directory_uri() . '/assets/img/logo.svg';
      $this->darkLogo = (new Image($src))
        ->addClass('logo logo-dark');
    }
    elseif (file_exists($logo)) {
      $src = get_template_directory_uri() . '/assets/img/logo.svg';
      $this->darkLogo = (new Image($src))
        ->addClass('logo logo-dark');
    }
    if (file_exists($light)) {
      $src = get_template_directory_uri() . '/assets/img/logo-light.svg';
      $this->lightLogo = (new Image($src))
        ->addClass('logo logo-light');
    }

    // TODO: check for for png, etc

  }

  function setDarkLogo($logo) {
    $src  = get_template_directory_uri() . '/assets/img/' . $logo;
    $this->darkLogo = (new Image($src))
      ->addClass('logo logo-dark');
      return $this;
  }

  function setMenu() {
    $this->menu = (new MainMenu());
    return $this->menu;
  }

  function setMobileMenu() {
    $this->mobileMenu = (new Part())
      ->setClass('menu-mobile');
    // TODO: move to method
    $this->mobileMenu->addPart()
      ->setClass('menu-mobile__header')
      ->addPart()
        ->setClass('menu-mobile__exit');
  }

  protected function prepareBrand() {
    $brand = $this->getBrand();
    if ($this->darkLogo) {$brand->insertPart($this->darkLogo);}
    if ($this->lightLogo) {$brand->insertPart($this->lightLogo);}
    if ($this->brandName) {$brand->insertPart($this->getBrandName());}
    $this->insertPart($brand);
  }

  protected function prepareMainMenu() {
    $menu = $this->getMenu();
    $this->getMobileMenu()->insertPart($menu);
  }

  protected function prepareMobileMenu() {
    $this->prepareMainMenu();
    $this->mobileMenu->addPart('menu-mobile__footer');
    $this->insertPart($this->getMobileMenu());
  }

  protected function prepareToggle() {
    $toggle = (new Part())
      ->setClass('menu-main__toggle')
      ->addHtml("
        <span class='menu-main__toggle__label'>MENU</span>
        <div class='menu-main__toggle__icon'>
          <div class='menu-main__toggle__top'></div>
          <div class='menu-main__toggle__mid'></div>
          <div class='menu-main__toggle__bot'></div>
        </div>
      ");
    $this->insertPart($toggle);
  }

  function build() {
    $this->prepareBrand();
    $this->prepareMobileMenu();
    $this->prepareToggle();
    return parent::build();
  }

//
//   function addMenuButton($label,$link) {
//     $this->button = "
//       <li class='menu-main__item'>
//         <a class='menu-main__button'>$label</a>
//         <div class='menu-main__item__title menu-main__button__title'>
//           $label
//         </div>
//       </li>
//     ";
//     return $this;
//   }
//
//   function setMenu() {
//     if (!isset($this->menuMain)) {
//       $this->menuMain = (new MenuMain('menu-main',$this));
//       return $this->menuMain;
//     } else {wp_die('Main Menu already set.');}
//   }
//
//   function addMenuItems($items) {
//     foreach ($items as $item) {
//       if (is_int($item)) {$item = get_post($item);}
//       elseif (is_string($item)) {$item  = get_page_by_path($item);}
//       $children = get_posts(array('post_parent'=>10,'post_type'=>'page'));
//       if ($children) {}
//       // Build item
//       $menuItem = "
//         <li class='menu-main__item'>
//           <div class='menu-main__item__title'>
//             $item->post_title
//           </div>
//         </li>
//       ";
//     }
//     return $this;
//   }
//
//   function addMainPages() {
//
//   }
//
//   // TODO: Create menu item and
//
//   function setSiteName($name=null) {
//     if ($name == false) {return $this;}
//     elseif ($name == null) {$name = get_bloginfo('name');}
//     $this->siteName = "<div class='nav-main__name'>$name</div>";
//     return $this;
//   }
//
//   function setBrand() {
//     $home_link = get_bloginfo('url');
//     if (!$this->logos) {$this->setName();}
//     if ($this->siteName) {$this->setSiteName();}
//     $this->brand = "
//       <a class='nav-main__brand' href='$home_link'>
//         $this->siteName
//         $this->logos
//       </a>
//     ";
//     return $this;
//   }
//
//   function addLogo($file) {
//     // TODO: check for for png, etc
//     $logo = \bp_get_theme_img($file,'nav-main__logo');
//     $this->logos = $logo . $this->brand;
//     return $this;
//   }
//
//   // TODO: create class or function for generating social
//   function addSocial() {
//     $accounts = get_field('main_social','option');
//     if (!$accounts) {return $this;}
//     $items = '';
//     if (!$accounts) {return $this;}
//     foreach ($accounts as $account) {
//       $platform = $account['platform'];
//       $iconClass = 'icon-social-' . $platform;
//       $icon = bp_get_theme_img('icon-social-' . $platform . '-white.svg','nav-main__social-icon');
//       $link = $account['link'];
//       $items .= "
//         <a href='$link' class='nav-main__social-icon-container'>$icon</a>
//       ";
//     }
//     $this->social = "
//       <div class='nav-main__social'>
//         $items
//       </div>
//     ";
//     return $this;
//   }
//
//   function build() {
//     $this->setBrand();
//     // Main Menu
//     if (!$this->menuMain) {
//       $this->setMenu();
//     }
//     $menuMain = $this->menuMain->build();
//     return "
//       $this->navBar
//       <nav class='$this->navClass'>
//
//         <div class='nav-main__wrap'>
//           $this->brand
//           $menuMain
//           $this->social
//
//
//
//         </div>
//       </nav>
//     ";
//   }
//
// }
//
// class SubMenu {
//
//
//
// }
//
// class MenuMain extends Part {
//
//   protected $button;
//   protected $items;
//
//   function init() {
//     $this->setClass('menu-mobile');
//   }
//
//   function addMenuButton($label,$link) {
//     if (!isset($this->button)) {
//       $this->button = "
//         <a class='menu-main__item' href='$link'>
//           <div class='menu-main__button'>$label</div>
//           <div class='menu-main__item__title menu-main__button__title'>
//             $label
//           </div>
//         </a>
//       ";
//     } else {wp_die('Only one menu button allowed.');}
//     return $this;
//   }
//
//   function addMainPages($pages=null) {
//     if (!$pages) {$pages = bp_var('main_pages');}
//     if (!$pages) {return $this;}
//     foreach ($pages as $item) {
//       if (is_int($item)) {
//         $item = get_post($item);
//       }
//       // Sub Menu
//       $sub_menu = '';
//       if (isset($item->children)) {
//         $sub_items = '';
//         foreach ($item->children as $child) {
//           $link = get_permalink($child->ID);
//           $sub_items .= "
//             <div class='menu-main__sub-item'>
//               <a class='menu-main__sub-item__title' href='$link'>
//                 $child->post_title
//               </a>
//             </div>
//           ";
//         }
//         $sub_menu = "
//           <div class='menu-main__sub-menu'>
//             $sub_items
//           </div>
//         ";
//       }
//       // Build item
//       $link = get_permalink($item->ID);
//       $menuItem = "
//         <div class='menu-main__item'>
//           <a class='menu-main__item__title' href='$link'>
//             $item->post_title
//           </a>
//           $sub_menu
//         </div>
//       ";
//       $this->items .= $menuItem;
//     }
//     return $this;
//   }
//
//   function addMenuItems() {
//
//   }
//
//   function buildInit() {
//     if (empty($this->items)) {$this->addMainPages();}
//     if ($this->button) {$this->items .= $this->button;}
//     $this->part = "
//       <div class='menu-main'>
//         $this->items
//       </div>
//       <div class='menu-mobile__exit'></div>
//     ";
//   }

}


class MainMenu extends Part {

  protected $items;

  function init() {
    $this->setClass('menu-main');
  }

  function getItems() {
    if (!isset($this->items)) {
      $this->items = (new Part())
        ->setTag(false)
        ->setDebugId(1);
    }
    return $this->items;
  }

  function addMainPages($pages=null) {
    if (!$pages) {$pages = bp_var('main_pages');}
    if (!$pages) {return $this;}
    foreach ($pages as $page) {
      $this->addMenuItem($page);
    }
    return $this;
  }

  function addMenuItem($item,$chain=false) {
    $menuItem = (new MenuItem($item,$this));
    if (is_object($item)) {
      $menuItem ->setLabel($item->title);
    } elseif (is_int($item)) {
      $item = get_post($item);
      $menuItem->setPost($item);
    } elseif (is_string($item)) {
      $menuItem->setLabel($item);
    }
    $this->getItems()->addPart($menuItem);
    if ($chain) {return $menuItem;}
    else {return $this;}
  }

  function addMenu($id) {
    $items = bp_get_menu($id);
    foreach ($items as $item) {
      $this->addMenuItem($item,true);
    }
    return $this;
  }

  function setButton($label,$chain=true) {
    $button = $this->addMenuItem($label,true)
      ->setClass('menu-main__button');
    return $button;
  }

  protected function prepareItems() {
    if (!isset($this->items)) {$this->addMainPages();}
    $items = $this->getItems()->getParts();
    if ($items) {$this->insertPart($this->getItems());}
  }

  function build() {
    $this->prepareItems();
    return parent::build();
  }

}


class MenuItem extends Part {

  protected $label;
  protected $itemTitle;
  protected $itemParent;
  protected $post;
  protected $subMenu;

  function init() {
    if (is_object($this->name)) {
      $this->post = $this->name;
      $this->itemTitle = $this->post->title;
    }
    if (isset($this->post->sub_menu)) {$this->setSubMenu();}
  }

  function getLabel() {
    if (!isset($this->label)) {$this->setLabel();}
    return $this->label;
  }

  function getItemParent() {
    return $this->checkSet('itemParent');
  }

  function getSubMenu() {
    return $this->checkSet('subMenu');
  }

  protected function setItemParent() {
    $this->itemParent = $this->post->menu_item_parent;
  }

  function setLabel($label=null) {
    $post = $this->post;
    if (!$label && $post) {
      $label = $post->title ?? $post->post_title;
    }
    $label = (new Part())
      ->setClass("item__label")
      ->setTag('a')
      ->addHtml($label);
    $this->label = $label;
    return $this;
  }

  function setPost($post) {
    $this->post = $post;
    return $this;
  }

  function setSubMenu() {
    $post = $this->post;
    if ($post->sub_menu) {
      $this->addClass('has--children');
      $this->subMenu = (new Part())
        ->setClass('menu-secondary');

      foreach ($post->sub_menu as $item) {
        $el = (new MenuItem($item));
        $this->subMenu->insertPart($el);
      }

    }
  }

  protected function prepareLabel() {
    $this->insertPart($this->getLabel());
  }

  protected function prepareLink() {
    $post = $this->post;
    $label = $this->getLabel();
    if ($this->post) {
      if ($post->url) {$label->setLink($post->url);}
      else {$label->setTag('div');}
      if (!empty($post->target)) {$this->setTarget('__blank');}
    }
  }

  function build() {

    if ($this->itemTitle) {$this->addClass($this->itemTitle);}

    if ($this->getItemParent()) {$this->addClass('item-secondary');}
    else {$this->addClass('item-primary');}


    $this->prepareLabel();
    $this->prepareLink();

    if ($this->subMenu) {
      $this->insertPart($this->getSubMenu());
    }

    return parent::build();
  }

}
