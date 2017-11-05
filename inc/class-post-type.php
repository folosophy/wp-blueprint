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
  private $singularName;
  protected $rewrite = array();
  protected $tags;

  function __construct($postType,$plural=null) {
    $this->postType = $postType;
    $this->setPublic(true);
    $this->setSupports();
    if ($plural) {$this->setPluralName($plural);}
    add_action('init',array($this,'register'));
  }

  function addGroup($name) {
    $group = (new acf\Group($name,$this))
      ->setLocation($this->postType);
    return $group;
  }

  function setAllItems($label) {
    $this->labels['all_items'] = $label;
    return $this;
  }

  function setArchivePage($page) {
    if (!$page) {$page = get_page_by_path($this->label);}
    $this->args['archive_page'] = $page;
    return $this;
  }

  function setArchiveTitle($title) {
    $this->args['archive_title'] = $title;
    return $this;
  }

  function setCategory() {
    $category = (new Taxonomy($this->postType . '_category'))
      ->setHierarchical(true)
      ->setPostType($this->postType);
    return $this;
  }

  function setLabels($labels,$single_value=null) {
    if (is_string($labels)) {
      $key = $labels;
      $labels = array();
      $labels[$key] = $single_value;
    }
    foreach ($labels as $key => $val) {
      $this->labels[$key] = $val;
    }
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
      array_push($location,$this->postType);
      return $location;
    });
    return $this;
  }

  function setMenuPosition($pos=20) {
    $this->args['menu_position'] = $pos;
    return $this;
  }

  function setName($plural,$singular) {
    $plural = ucwords(str_replace('_',' ',$plural));
    $singular = ucwords(str_replace('_',' ',$singular));
    $this->labels['name'] = $plural;
    $this->labels['singular_name'] = $singular;
    return $this;
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
    $name = ucwords($name);
    $this->name = $name;
    $this->labels['name'] = $name;
    $this->label = $name;
    $this->pluralName = $name;
    $this->labels['plural_name'] = $name;
    return $this;
  }

  function setPublic($public=true) {
    if ($public) {$this->args['public'] = true;}
  }

  function setRecentTitle($title) {
    $this->labels['recent_title'] = $title;
    return $this;
  }

  function setSingularName($name) {
    if (!$name) {$name = $this->postType;}
    $this->singularName = $name;
    $this->labels['singular_name'] = $name;
    return $this;
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

  function setSlug($slug=null) {
    if (!$slug) {$slug = $this->name;}
    $this->rewrite['slug'] = $slug;
    return $this;
  }

  function register() {
    $this->args['labels'] = $this->labels;
    $this->args['rewrite'] = $this->rewrite;
    register_post_type($this->postType,$this->args);
    remove_post_type_support($this->postType,'comments');
  }

}
