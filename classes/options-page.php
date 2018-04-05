<?php

namespace Blueprint;

class OptionsPage {

  protected $name;
  protected $options = array();
  protected $parent;
  protected $label;

  function __construct($slug) {
    $this->options['menu_slug'] = str_replace('_','-',$slug);
    $this->setLabel($slug);
    $this->setPageTitle();
    $this->setCapability();
    add_action('init',array($this,'add'));
  }

  function addSubPage($name,$chain=false) {
    $page = (new OptionsPage('footer'))
      ->setParent('?page=' . $this->options['menu_slug']);
    return $this;
  }

  function setLabel($label=null) {
    $label = str_replace('_',' ',$label);
    $label = ucwords($label);
    $this->label = $label;
    $this->options['menu_title'] = $label;
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
    if (!$title) {$title = $this->label;}
    $this->options['page_title'] = $title;
    return $this;
  }

  function setCapability($capability=null) {
    if (!$capability) {$capability = 'manage_options';}
    $this->options['capability'] = $capability;
    return $this;
  }

  function setRedirect($redirect) {
    if (is_bool($redirect)) {$this->options['redirect'] = $redirect;}
    return $this;
  }

  protected function getOptions() {
    return $this->options;
  }

  function add() {
    $parent = $this->parent;
    if ($parent) {
      \acf_add_options_sub_page($this->getOptions());
    }
    else {\acf_add_options_page($this->getOptions());}
  }

}
