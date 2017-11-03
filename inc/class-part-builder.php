<?php

// Used In: part, template

namespace Blueprint\Part;
use \Blueprint as bp;

trait Builder {

  use bp\Chain;

  protected $build;
  protected $field;
  protected $id;
  protected $part;
  protected $parts = array();
  protected $prefix;
  protected $name;
  protected $class='';
  protected $tag;

  function addVideo($name='',$chain=false) {
    $field = $this->field['video'];
    $part = (new Video($field));
    $this->addPart($part);
    return $this;
  }

  function addContainer($type='main') {
    $class='container-' . $type;
    $container = (new Part())
      ->setClass($class);
    return $this->addPart($container,true);
  }

  function addWrap($type='main') {
    $class='wrap-' . $type;
    $wrap = (new Part())
      ->setClass($class);
    $this->addPart($wrap,true);
    return $wrap;
  }

  function setAlign($align='center') {
    $this->class .= ' ' . $align . ' ';
    return $this;
  }

  function setClass($class) {
    $this->class = $class;
    return $this;
  }

  function setTag($tag='div') {
    $this->tag = $tag;
    return $this;
  }

  function addButton() {
    $field = $this->field['button'];
    $part = (new Button('light',$field['label'],''));
    return $this->addPart($part);
  }

  function addClass($class) {
    $this->class .= ' ' . $class;
    return $this;
  }

  function addCopy($copy=null) {
    $part = (new Copy('copy',$this))
      ->setCopy($copy);
    $this->addPart($part);
    return $this;
  }

  function addHeadline($headline=null) {
    $part = (new Headline('headline',$this))
      ->setHeadline($headline);
    $this->addPart($part);
    return $this;
  }

  function addHtml($html) {
    if (!is_string($html)) {wp_die('addHtml expects string');}
    array_push($this->parts,$html);
    return $this;
  }

  // $part: Accepts part name or part object

  function addPart($part=null,$chain=false) {
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
    array_push($this->parts,$part);

    if ($chain) {return $part;}
    else {return $this;}
  }

  function addSection($name) {
    $section = (new Section($name,$this))
      ->setTag('section');
    return $this->addPart($section,true);
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

  function setId($id) {
    $this->id = "id='$id'";
    return $this;
  }

  function setWrap($wrap) {
    $this->class .= 'wrap-' . $wrap;
    return $this;
  }

  function build() {
    // Child build init
    if (method_exists($this,'buildInit')) {
      $this->buildInit();
    }
    // Get part or parts
    if ($this->part) {$body = $this->part;}
    else {$body = $this->buildParts();}
    // Tag
    if (!$this->tag) {$this->setTag();}
    $tag = $this->tag;
    // Id
    if ($this->id) {$id = "id='$this->id'";}
    else {$id = null;}
    // Build
    return "
      <$tag $id class='$this->class'>
        $body
      </$tag>
    ";
  }

  function buildParts() {
    $parts = '';
    foreach($this->parts as $part) {
      if (is_object($part)) {
        $parts .= $part->build();
      } else {
        $parts .= $part;
      }
    }
    return $parts;
  }

  function render() {
    echo $this->build();
  }

}
