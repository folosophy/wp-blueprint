<?php

namespace Blueprint;
use Blueprint\Part as part;

class Header {

  use Chain;

  protected $siteName;
  protected $siteUrl;
  protected $head;
  protected $menuMain;
  protected $nav;
  protected $navBar;

  function __construct() {
    $this->setMeta();
  }

  function setNav($chain=false) {
    $nav = (new Part\NavMain());
    $this->nav = $nav;
    return $this->chain($nav,$chain);
  }

  function setNavbar() {
    $navbar = (new Part\NavBar());
    $this->navBar = $navbar;
    return $this->chain($navbar,true);
  }

  private function setParts() {
    $this->setHead();
  }

  private function setMeta() {
    $this->setSiteName();
    $this->setPageTitle();
    $this->setSiteUrl();
  }

  private function setSiteName($name=null) {
    if (!$name) {$name = get_bloginfo('name');}
    $this->siteName = $name;
  }

  public function setSiteUrl() {
    $this->siteUrl = get_bloginfo('url');
  }

  public function setPageTitle($title=null) {
    if (!$title) {$title = get_the_title();}
    $this->pageTitle = $title;
  }

  function build() {
    if (!$this->nav) {$this->setNav();}
    $nav = $this->nav->build();
    if ($this->navBar) {$navbar = $this->navBar->build();}
    return "
      <header class='header-main'>
        $navbar
        $nav
      </header>
    ";
  }

  function render() {
    echo $this->build();
  }

  function preBuild() {
    $navbar = $this->navBar;
    if ($navbar) {
      $this->navBar = $this->navBar->build();
    }
  }

  public function renders() {
    $this->setParts();
    $menuMain = new MenuMain();
    $this->menuMain = $menuMain->getBuild();
    echo "
          <div class='site-bg'></div>
            <header class='header-main'>
              <nav class='nav-main'>
                <div class='nav-main__wrap'>
                  <a class='nav-main__brand' href='$this->siteUrl'>
                    <div class='nav-main__name'>$this->siteName</div>
                  </a>
                  <div class='menu-mobile'>
                    <header class='menu-mobile__header'>
                      <div class='menu-mobile__exit'>
                        <div class='menu-mobile__exit-icon'></div>
                      </div>
                    </header>
                    $this->menuMain
                  </div>
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
            </header>

            <div id='page'>

            ";
  }

}
