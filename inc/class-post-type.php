<?php

namespace Blueprint;
use \Blueprint\Acf as acf;

class PostType {

  protected $category;
  protected $mediaFormats = array();
  private $postType;
  private $args = array();
  private $label;
  private $labels = array();
  protected $pluralName;
  protected $rewrite = array();
  protected $tags;

  function __construct($postType,$pluralName=null) {
    $this->postType = $postType;
    $this->setPluralName($pluralName);
    $this->setLabel();
    $this->setPublic(true);
    $this->setSupports();
    add_action('init',array($this,'register'));
  }

  function addGroup($name) {
    $group = (new acf\Group($name,$this))
      ->setLocation($this->postType);
    return $group;
  }

  function setArchivePage($page) {
    if (!$page) {$page = get_page_by_path($this->label);}
    $this->args['archive_page'] = $page;
    return $this;
  }

  function setCategory() {
    $category = (new Taxonomy($this->postType . '_category'))
      ->setHierarchical(true)
      ->setPostType($this->postType);
    return $this;
  }

  function setMedia($formats) {
    if (is_string($formats)) {$formats = array($formats);}
    foreach ($formats as $key => $val) {
      if(is_int($key)) {$key = $val;}
      $val = ucwords($val);
      $this->mediaFormats[$key] = $val;
    }
    add_action('current_screen',function() {
      // Populate media format choices
      $post_type = get_current_screen();
      $post_type = $post_type->id;
      if ($post_type == $this->postType) {
        add_filter('acf/load_field/name=featured_media',function($field) {
          $field['sub_fields'][0]['choices'] = $this->mediaFormats;
          return $field;
        });
      }
    });
    // Add post type location
    add_filter('bp_featured_media_location',function($location) {
      if (is_string($location)) {$location = array($location);}
      array_push($location,$this->postType);
      return $location;
    });
    return $this;
  }

  function setName($name=null) {
    if (!$name) {$name = $this->label;}
    $this->labels['name'] = $name;
  }

  function setLabel($label=null) {
    if (!$label) {
      $label = $this->pluralName;
      $label = str_replace('_',' ',$label);
    }
    $label = ucwords($label);
    $this->label = $label;
    return $this;
  }

  function setPluralName($name=null) {
    if (!$name) {$name = $this->postType;}
    $this->pluralName = $name;
    return $this;
  }

  function setPublic($public=true) {
    if ($public) {$this->args['public'] = true;}
  }

  function setSupports($features=null) {
    if (!$features) {$features = array('title','thumbnail','editor');}
    elseif (is_string($features)) {$features = array($features);}
    $this->args['supports'] = $features;
    return $this;
  }

  function setMenuIcon($icon) {
    $icon = 'dashicons-' . $icon;
    $this->args['menu_icon'] = $icon;
    return $this;
  }

  function setTaxonomies($taxes) {
    $this->args['taxonomies']   = $taxes;
    $this->args['hierarchical'] = true;
    $this->args['show_ui']      = true;
    return $this;
  }

  function setSlug($slug) {
    $this->rewrite['slug'] = $slug;
    return $this;
  }

  function register() {
    $this->args['label']  = $this->label;
    $this->args['labels'] = $this->labels;
    register_post_type($this->postType,$this->args);
    remove_post_type_support($this->postType,'comments');
  }

}
