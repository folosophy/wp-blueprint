<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class Part {

  use bp\Chain;

  protected $atts = array();
  protected $build;
  protected $defaultBuild;
  protected $debugId;
  protected $field;
  protected $id;
  protected $lazy;
  protected $linkType;
  protected $part;
  protected $parts = array();
  protected $post;
  protected $post_id;
  protected $prefix;
  protected $name;
  protected $class='';
  protected $tag;

  function __construct($name='',$parent=null) {
    $this->setName($name);
    //$this->title = ucwords($this->name);
    if ($parent) {
      $this->setParent($parent);
      if (isset($this->parent) && method_exists($parent,'getField')) {
        $this->field = $parent->getField();
      }
    }
    if (method_exists($this,'init')) {$this->init();}
  }

  function addCard($post=null,$chain=false) {
    $part = (new Card(null,$this));
    if ($post) {$part->setPost($post);}
    return $this->addPart($part,$chain);
  }

  function addForm($name=null,$chain=true) {
    $part = (new Form($name));
    return $this->addPart($part,$chain);
  }

  function addGrid($name=null,$chain=true) {
    $part = (new Grid());
    return $this->addPart($part,$chain);
  }

  function addIcon($name=null,$chain=true) {
    $part = (new Icon($name));
    return $this->addPart($part,$chain);
  }

  function addImage($name='',$chain=true) {
    $part = (new Image($name,$this));
    return $this->addPart($part,$chain);
  }

  function addVideo($name='',$chain=false) {
    $part = (new Video($name));
    return $this->addPart($part,$chain);
  }

  function addContainer($type='main',$chain=true) {
    $class='container-' . $type;
    $part = (new Part())
      ->setClass($class);
    return $this->addPart($part,$chain);
  }

  function addP($text=null,$chain=false) {
    $part = (new Text())
      ->setText($text)
      ->setTag('p');
    return $this->addPart($part,$chain);
  }

  function addP2($text=null,$chain=true) {
    return $this->addP($text,$chain)
      ->setClass('p2');
  }

  function addPostGrid($name=null,$chain=true) {
    $part = (new PostGrid($name,$this));
    return $this->addPart($part,$chain);
  }

  function addWrap($type='main',$chain=true) {
    $class='wrap-' . $type;
    $part = (new Part())
      ->setClass($class);
    return $this->addPart($part,$chain);
  }

  protected function checkSet($prop,$method=null) {
    if (!$method) {$method = $prop;}
    $setMethod = 'set' . $method;
    if (!isset($this->$prop)) {$this->$setMethod();}
    return $this->$prop;
  }

  // function getFormat($part,$format) {
  //   $formats = array('part','el','raw');
  //   if (!in_array($format)) {wp_die('getFormat format invalid.');}
  //   switch ($format) {
  //     case 'part'
  //   }
  // }

  // function getLinkType() {
  //   if (!$this->linkType) {$this->setLinkType();}
  //   return $this->linkType;
  // }

  function getAttr($attr) {
    return $this->atts[$attr] ?? false;
  }

  function getName() {
    return $this->name;
  }

  function getParts() {
    return $this->parts;
  }

  function getPost() {
    return $this->post;
  }

  function getPostId() {
    if ($this->post) {return $this->post->post_id;}
    else {return get_the_ID();}
  }

  protected function initPart($part) {
    if (!isset($this->$part)) {
      $method = 'set' . ucwords($part);
      $this->$method();
    }
    return $this->$part;
  }

  // protected function initPart($name) {
  //   // Checks to see if part is set
  //   if (isset($this->))
  // }

  function setAlign($align='center') {
    $this->class .= ' ' . $align . ' ';
    return $this;
  }

  function setAlt($alt=null) {
    if (!$alt) {$alt = get_the_title($this->post_id);}
    $this->setAttr('alt',$alt);
    return $this;
  }

  function setClass($class=null) {
    if (!isset($class)) {$class = $this->name;}
    $this->class = $class;
    $this->atts['class'] = $class;
    return $this;
  }

  protected function setPart($part,$chain,$prop) {
    $this->$prop = $part;
    if ($chain) {return $this->$prop;}
    else {return $this;}
  }

  function setTag($tag='div') {
    $this->tag = $tag;
    return $this;
  }

  function addAttr($attr,$val) {
    if (!empty($this->atts[$attr])) {$this->atts[$attr] .= ' ' . $val;}
    else {$this->atts[$attr] = $val;}
  }

  function addButton($name=null,$chain=true) {
    $part = (new Button($name,$chain));
    return $this->addPart($part,$chain);
  }

  function addClass($class) {
    $this->addAttr('class',$class);
    if (isset($this->class)) {$this->class = $this->atts['class'];}
    return $this;
  }

  function addCopy($copy=null,$chain=false) {
    if (!$copy && isset($this->field['copy'])) {$copy = $this->field['copy'];}

    if ($copy) {
      $part = (new Part())
        ->setTag(false);
      $copy = str_replace('</p>','',$copy);
      $copy = explode('<p>',$copy);
      $copy = array_filter($copy);
      foreach ($copy as $p) {
        $part->addP($p);
      }
    } else {
      $part = (new Text());
    }

    return $this->insertPart($part,$chain);
  }

  function addH($headline=null,$chain=false) {
    $part = (new Headline($headline,$this))
      ->setHeadline($headline);
    return $this->addPart($part,$chain);
  }

  function addH3($headline=null,$chain=false) {
    $part = $this->addH($headline,true)
      ->setTag('h3');
    return $this->chain($part,$chain);
  }

  function addH4($headline=null,$chain=false) {
    $part = $this->addH($headline,true)
    ->setTag('h4');
    return $this->chain($part,$chain);
  }

  function addHeadline($headline=null,$chain=false) {
    $part = (new Headline($headline,$this))
      ->setHeadline($headline);
    return $this->addPart($part,$chain);
  }

  function addRule($type='small',$chain=false) {
    $type = 'rule-' . $type;
    $part = (new Part($type))
      ->setTag('hr')
      ->setClass($type)
      ->setLazy(true);
    return $this->addPart($part,$chain);
  }

  function addHtml($html) {
    if (!is_string($html)) {wp_die('addHtml expects string');}
    array_push($this->parts,$html);
    return $this;
  }

  function addPart($part=null,$chain=true,$prop='parts') {
    if (is_string($prop)) {
      if (!is_array($this->$prop)) {$this->$prop = array();}
    }
    $part = $this->preparePart($part);
    array_push($this->$prop,$part);
    if ($chain) {return $part;}
    else {return $this;}
  }

  function addPrependPart($part=null,$chain=true,$prop='parts') {
    if (!is_array($this->$prop)) {$this->$prop = array();}
    $part = $this->preparePart($part);
    array_unshift($this->$prop,$part);
    if ($chain) {return $part;}
    else {return $this;}
  }

  function insertPart($part,$chain=false) {
    array_push($this->parts,$part);
    if ($chain) {return $part;}
    else {return $this;}
  }

  // Var: $index can be int or name
  function insertPartAfter($part,$index=null) {
    if (!$index || $index >= count($this->parts)) {
      array_push($this->parts,$part);
    } else {
      $index = $this->getPartIndex($index);
      $before = array_slice($this->parts,0,$index + 1);
      $after  = array_slice($this->parts,$index + 1);
      $this->parts = array_merge($before,array($part),$after);
    }
    return $this;
  }

  function insertPartBefore($part,$index=null) {
    if (!$index || $index < 1) {
      array_unshift($this->parts,$part);
    } else {
      $index = $this->getPartIndex($name);
    }
    return $this;
  }

  function getPartIndex($name) {
    foreach ($this->parts as $i => $part) {
      if (is_object($part)) {
        if ($part->getName() == $name) {
          return $i;
        }
      }
    }
  }

  function setLazy($bool=true) {
    $this->lazy = $bool;
    return $this;
  }

  function setLink($link=null,$link_type=null) {

    $this->setTag('a');

    if (is_array($link)) {
      $section   = $link[1];
      $link      = $link[0];
    }
    if ($link === false) {
      $this->link = false;
      return $this;
    }
    if (!$link_type) {
      $link_type = $this->field['link_type'] ?? 'section';
    }
    if (empty($link)) {
      $link = $this->field[$link_type . '_link'] ?? 'next';
      if (empty($link)) {$link = 'next';}
    }
    if (is_int($link)) {
      $link_type = 'internal';
    }

    switch ($link_type) {
      case 'internal': $link = get_permalink($link); break;
      case 'external': $this->setAttr('target','_blank'); break;
      case 'section' : $link = '#section-' . $link; break;
      case 'page_section':
        $id = $link;
        $link = '#section-' . $section;
        if (get_the_ID() !== $id) {
          $link = get_permalink($id) . $link;

        }
        break;
      default : $link = '#section-next';
    }

    $this->setAttr('href',$link);
    return $this;
  }

  function preparePart($part) {
    if (!$part) {
      $part = (new Part(null,$this));
      $chain = true;
    } elseif (is_string($part)) {
      $name = $part;
      $part = (new Part($name,$this));
    }
    $part
      ->setParent($this)
      ->setField($this->getField());
    return $part;
  }

  function prependPart($part=null,$chain=true,$prop='parts') {
    if (!is_array($this->$prop)) {$this->$prop = array();}
    $part = $this->preparePart($part);
    array_unshift($this->$prop,$part);
    if ($chain) {return $part;}
    else {return $this;}
  }

  function addSection($name) {
    $section = (new Section($name,$this))
      ->setTag('section');
    return $this->addPart($section,true);
  }

  function addSpacer($name='spacer',$chain=true) {
    $part = (new Spacer($name));
    return $this->addpart($part,$chain);
  }

  function setDefaultBuild($bool) {
    $this->defaultBuild = (bool) $bool;
    return $this;
  }

  // TODO: Accept field name or object?
  function setField($field=null) {
    if (!$field) {
      $this->field = get_field($this->prefix . $this->name);
    } else {$this->field = $field;}
    return $this;
  }

  function setPost($post) {
    if (is_object($post)) {
      $this->post    = $post;
      $this->post_id = $post->ID;
    }
    return $this;
  }

  function getField() {
    return $this->field;
  }

  function endPart() {
    return $this->end();
  }

  function setId($id=null) {
    if ($id !== false) {$this->id = $id;}
    return $this;
  }

  function setAttr($attr,$val) {
    $this->atts[$attr] = $val;
    return $this;
  }

  // function setLinkType($type=null) {
  //   $types = array(
  //     'internal',
  //     'external',
  //     'section'
  //   );
  //   if (!$type) {
  //     $type = $this->field['link_type'] ?? 'section';
  //   }
  //   if (!in_array($type,$types)) {wp_die('Part setLinkType invalid type');}
  //   $this->linkType = $type;
  //   return $this;
  // }

  function setDebugId($id) {
    $this->debugId = $id;
    return $this;
  }

  function setName($name=null) {
    if ($name) {$this->name = $name;}
    return $this;
  }

  function setWrap($wrap) {
    $this->class .= 'wrap-' . $wrap;
    return $this;
  }

  function dumpField() {
    var_dump($this->field);
    return $this;
  }

  function dumpPart() {
    diedump($this);
  }

  function dumpPartNames($parts=null) {
    if (!$parts) {$parts = $this->parts;}
    $names = array_map(function($part) {
      return $part->getName();
    },$parts);
    diedump($names);
  }

  function build() {

    if ($this->lazy) {
      $this->addClass('lazy-item lazy-unloaded');
    }

    // Child build init
    if (method_exists($this,'buildInit')) {
      $this->buildInit();
    }

    // Child build init
    if (method_exists($this,'prepare')) {
      $this->prepare();
    }

    $parts = $this->buildParts();

    // Tag
    if (!isset($this->tag)) {$this->setTag();}

    if (!$this->tag) {
      return $parts;
    } else {
      // Id
      if ($this->id) {$id = "id='$this->id'";}
      else {$id = null;}

      // Attributes
      if ($this->atts) {
        if (is_string($this->atts)) {
          $atts = $this->atts;
        } else {
          $atts = '';
          foreach ($this->atts as $key => $val) {
            if ($val !== false) {
              $atts .= " " . $key . '="' . $val . '"';
            }
          }
        }
      } else {$atts = null;}

      // Build
      return $this->addTag(
        $parts,
        $this->tag,
        $atts
      );
    }

  }

  protected function addTag($string,$tag,$atts) {
    if (!$tag == false) {
      $string = "
        <$tag $atts>$string</$tag>
      ";
    }
    return $string;
  }

  protected function buildParts($parts=null) {
    if (!$parts) {$parts = $this->parts;}
    $el = '';
    if (is_string($parts)) {$parts = array($parts);}
    foreach($parts as $part) {
      if (is_object($part)) {
        //if (!method_exists($part,'build')) {diedump($part);}
        $el .= $part->build();
      } else {
        $el .= $part;
      }
    }
    return $el;
  }

  function render() {
    echo $this->build();
  }

}
