<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class Part {

  use bp\Chain;

  protected $atts = array();
  protected $build;
  protected $field;
  protected $id;
  protected $part;
  protected $parts = array();
  protected $prefix;
  protected $name;
  protected $class='';
  protected $tag;

  function __construct($name='',$parent=null) {
    // if (strpos($name,'-')) {
    //   diedump($name);
    //   $name = explode('-',$name);
    //   $this->prefix = $name[0] . '_';
    //   $this->name = $name[1];
    // } else {
    //   $this->name= $name;
    // }
    $this->name = $name;
    $this->title = ucwords($this->name);
    if ($parent) {
      $this->setParent($parent);
      if (isset($this->parent) && method_exists($parent,'getField')) {
        $this->field = $parent->getField();
      }
    }
    if (method_exists($this,'init')) {$this->init();}
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

  function addImage($name='',$chain=false) {
    $part = (new Image());
    return $this->addPart($part,$chain);
  }

  function addVideo($name='',$chain=false) {
    $part = (new Video($name));
    return $this->addPart($part,$chain);
  }

  function addContainer($type='main') {
    $class='container-' . $type;
    $container = (new Part())
      ->setClass($class);
    return $this->addPart($container,true);
  }

  function addPostGrid($name=null,$chain=true) {
    $part = (new PostGrid());
    return $this->addPart($part,$chain);
  }

  function addWrap($type='main',$chain=true) {
    $class='wrap-' . $type;
    $part = (new Part())
      ->setClass($class);
    return $this->addPart($part,$chain);
  }

  // function getFormat($part,$format) {
  //   $formats = array('part','el','raw');
  //   if (!in_array($format)) {wp_die('getFormat format invalid.');}
  //   switch ($format) {
  //     case 'part'
  //   }
  // }

  function getName() {
    return $this->name;
  }

  // protected function initPart($name) {
  //   // Checks to see if part is set
  //   if (isset($this->))
  // }

  function setAlign($align='center') {
    $this->class .= ' ' . $align . ' ';
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

  function addButton($name=null,$chain=true) {
    $part = (new Button($name));
    return $this->addPart($part,$chain);
  }

  function addClass($class) {
    if (is_string($this->atts)) {diedump($this->atts);}
    if (!isset($this->atts['class'])) {$this->atts['class'] = '';}
    $this->class .= ' ' . $class;
    $this->atts['class'] .= ' ' . $class;
    return $this;
  }

  function addCopy($copy=null,$chain=false) {
    $part = (new Copy('copy',$this))
      ->setCopy($copy);
    return $this->addPart($part,$chain);
  }

  function addHeadline($headline=null,$chain=false) {
    $part = (new Headline($headline,$this))
      ->setHeadline($headline);
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

  function insertPart($part) {
    array_push($this->parts,$part);
    return $this;
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

  // TODO: Accept field name or object?
  function setField($field=null) {
    if (!$field) {
      $this->field = get_field($this->prefix . $this->name);
    } else {$this->field = $field;}
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

  function setName($name=null) {
    $this->name = $name;
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

  function dumpPartNames($parts=null) {
    if (!$parts) {$parts = $this->parts;}
    $names = array_map(function($part) {
      return $part->getName();
    },$parts);
    diedump($names);
  }

  function build() {

    // Child build init
    if (method_exists($this,'buildInit')) {
      $this->buildInit();
    }

    // Child build init
    if (method_exists($this,'prepare')) {
      $this->prepare();
    }

    // Get part or parts
    if ($this->part) {$body = $this->part;}
    else {$body = $this->buildParts();}
    $body = $this->buildParts($body);

    // Tag
    if (empty($this->tag)) {$this->setTag();}
    $tag = $this->tag;

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
      $body,
      $this->tag,
      $atts
    );
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
