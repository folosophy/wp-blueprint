<?php

namespace Blueprint;

class OptionsPage {

  protected $options = array();
  protected $parent;
  protected $title;

  function __construct($slug) {
    $this->options['menu_slug'] = $slug;
    $this->setTitle($slug);
    $this->setPageTitle();
    $this->setMenuTitle();
    $this->setCapability();
    add_action('init',array($this,'add'));
  }

  function setTitle($title=null) {
    $title = str_replace('_',' ',$title);
    $title = ucwords($title);
    $this->title = $title;
    return $this;
  }

  function setIcon($icon) {
    $icon = 'dashicons-' . $icon;
    $this->options['icon_url'] = $icon;
    return $this;
  }

  function setParent($parent) {
    $this->options['parent_slug'] = $parent;
    $this->parent = $parent;
    return $this;
  }

  private function setPageTitle($title = null) {
    if (!$title) {$title = $this->title;}
    $this->options['page_title'] = $title;
    return $this;
  }

  private function setMenuTitle($title = null) {
    if (!$title) {$title = $this->title;}
    $this->options['menu_title'] = $title;
    return $this;
  }

  function setCapability($capability=null) {
    if (!$capability) {$capability = 'manage_options';}
    $this->options['capability'] = $capability;
    return $this;
  }

  protected function getOptions() {
    return $this->options;
  }

  function add() {
    $parent = $this->parent;
    if ($parent) {acf_add_options_sub_page($this->getOptions());}
    else {acf_add_options_page($this->getOptions());}
  }

}
