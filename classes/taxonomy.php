<?php

namespace Blueprint;

class Taxonomy {

  use Chain;

  private $taxonomy;
  private $postType;
  private $args = array();
  private $labels = array();

  function __construct($taxonomy,$postType=null) {
    $this->setTaxonomy($taxonomy);
    $this->setHierarchical(true);
    add_action('init',array($this,'register'),0);
  }

  function setLabel($label) {
    $label = ucwords($label);
    $this->args['label'] = $label;
    return $this;
  }

  function setMetaBox($bool) {
    $this->args['meta_box_cb'] = (bool) $bool;
    return $this;
  }

  function setPostType($type) {
    $this->postType = $type;
    return $this;
  }

  function setTaxonomy($taxonomy=null) {
    $this->taxonomy = $taxonomy;
    return $this;
  }

  // Default: false (tags)

  function setHierarchical($bool) {
    $this->args['hierarchical'] = $bool;
    return $this;
  }

  function register() {
    $this->args['labels'] = $this->labels;
    register_taxonomy($this->taxonomy,$this->postType,$this->args);
  }

}
