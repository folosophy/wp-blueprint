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

  // postType: singular

  function __construct($postType,$plural=null) {
    $this->postType = $postType;
    $this->setLabel($postType);
    $this->setPublic(true);
    $this->setSupports();
    if ($plural) {$this->setPluralName($plural);}
    add_action('init',array($this,'register'));
  }

  function setArg($key,$val) {
    $this->args[$key] = $val;
  }

  function setMedia($formats=null) {
    if (is_array($formats)) {diedump('PostType setMedia does not accept array.');}
    $formats = func_get_args();
    if (in_array('image',$formats)) {
      add_filter('bp/acf/group/featured_image',array($this,'addFeaturedImage'));
    }
    // TODO: filter invalid formats
    // $options = array('image','video');
    // if ($formats == null) {$formats = array('image');}
    // $this->mediaFormats = $formats;
    // add_action('bp/acf/group/featured_media',array($this,'addMediaLocation'));
    // add_action('acf/load_field/key=field_featured_media_format',array($this,'loadMediaFormats'));
    return $this;
  }

  function addFeaturedImage($group) {
    $group->getLocation()
      ->addLocation($this->postType);
    return $group;
  }

  function addMediaLocation($group) {
    $group->getLocation()->addLocation($this->postType);
    return $group;
  }

  function addGroup($name) {
    $group = (new acf\Group($name,$this))
      ->setLocation($this->postType);
    return $group;
  }

  function addSettingsPage() {
    if ( function_exists( 'acf_add_options_sub_page' ) ){
    	acf_add_options_sub_page(array(
    		'title'      => 'Settings',
    		'parent'     => 'edit.php?post_type=' . $this->postType,
    		'capability' => 'edit_posts',
        'slug'       => $this->postType . '_settings'
    	));
    }
    return $this;
  }

  function loadMediaFormats($field) {
    if (get_post_type() == $this->postType) {
      $choices = array();
      $formats = (array) $this->mediaFormats;
      foreach ($formats as $i => $key) {
        $choices[$key] = ucwords($key);
      }
      $field['choices'] = $choices;
      if (count($choices) == 1) {$field['wrapper']['class'] .= ' hide';}
    }
    return $field;
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

  function setCard($card) {
    if (!is_string($card)) {wp_die('PostType setCard expects string');}
    $this->args['card'] = $card;
    return $this;
  }

  function setCategory($name=null) {

    if (!$name) {$name = 'category';}

    $tax = (new Taxonomy($this->postType . '_' . $name,$this->postType))
      ->setPostType($this->postType)
      ->setLabel('Categories')
      ->setMetaBox(false)
      ->setHierarchical(false);

    $field = (new \Blueprint\Acf\Group($name))
      ->setLocation($this->postType)
      ->setPosition('side')
      ->setLabelPlacement('top');

      $field->addTaxonomy($this->postType . '_' . $name,true)
        ->setTaxonomy($this->postType . '_' . $name)
        ->setUi('radio');

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

  // function setMedia($formats) {
  //   if (is_string($formats)) {$formats = array($formats);}
  //   foreach ($formats as $key => $val) {
  //     if(is_int($key)) {$key = $val;}
  //     $val = ucwords($val);
  //     $this->mediaFormats[$key] = $val;
  //   }
  //   add_action('current_screen',function() {
  //     // Populate media format choices
  //     $post_type = get_current_screen();
  //     $post_type = $post_type->id;
  //     if ($post_type == $this->postType) {
  //       add_filter('acf/load_field/name=featured_media',function($field) {
  //         $field['sub_fields'][0]['choices'] = $this->mediaFormats;
  //         return $field;
  //       });
  //     }
  //   });
  //   // Add post type location
  //   add_filter('bp_featured_media_location',function($location) {
  //     array_push($location,$this->postType);
  //     return $location;
  //   });
  //   return $this;
  // }

  function setMenuPosition($pos=20) {
    $this->args['menu_position'] = $pos;
    return $this;
  }

  function setName($plural,$singular) {
    $plural = ucwords(str_replace('_',' ',$plural));
    $singular = ucwords(str_replace('_',' ',$singular));
    $this->setLabel($plural);
    $this->labels['name'] = $plural;
    $this->labels['singular_name'] = $singular;
    return $this;
  }

  function setLabel($label=null,$value=null) {
    if ($value) {
      $this->labels[$label] = $value;
    } else {
      if (!$label) {
        $label = $this->pluralName;
        $label = str_replace('_',' ',$label);
      }
      $label = ucwords($label);
      $this->label = $label;
    }
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
    $this->args['public'] = (bool) $public;
    return $this;
  }

  function setQueryable($bool) {
    $this->args['publicly_queryable'] = (bool) $bool;
    return $this;
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
    if (!$features) {$features = array('title');}
    if (!is_array($features)) {$features = func_get_args();}
    $this->args['supports'] = $features;
    return $this;
  }

  function setMenuIcon($icon) {
    $icon = 'dashicons-' . $icon;
    $this->args['menu_icon'] = $icon;
    return $this;
  }

  function setUi($ui) {
    $this->args['show_ui'] = (bool) $ui;
    return $this;
  }

  // function setTaxonomies($taxes) {
  //   $this->args['taxonomies']   = $taxes;
  //   $this->args['hierarchical'] = true;
  //   $this->args['show_ui']      = true;
  //   return $this;
  // }

  function setSlug($slug=null) {
    if (!$slug) {$slug = $this->name;}
    $this->rewrite['slug'] = $slug;
    $this->rewrite['with_front'] = false;
    return $this;
  }

  function register() {
    $this->args['label'] = $this->label;
    $this->args['labels'] = $this->labels;
    $this->args['rewrite'] = $this->rewrite;
    register_post_type($this->postType,$this->args);
    remove_post_type_support($this->postType,'comments');
  }

}
