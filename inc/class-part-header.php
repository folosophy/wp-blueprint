<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class Header extends Part {

  protected $siteName;
  protected $siteUrl;
  protected $head;
  protected $menuMain;
  protected $nav;
  protected $navBar;

  function __construct() {
    $this->setMeta();
  }

  function getNav() {
    if (!isset($this->nav)) {$this->setNav();}
    return $this->nav;
  }

  function setNav($name=null,$chain=true) {
    $nav = (new NavMain());
    $this->nav = $nav;
    return $this->chain($nav,$chain);
  }

  function setNavbar() {
    $navbar = (new NavBar());
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

  function preBuild() {
    $navbar = $this->navBar;
    if ($navbar) {
      $this->navBar = $this->navBar->build();
    }
  }

  function build() {
    if (!$this->nav) {$this->setNav();}
    $nav = $this->nav->build();
    if ($this->navBar) {$navbar = $this->navBar->build();}
    else {$navbar = null;}
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

}
