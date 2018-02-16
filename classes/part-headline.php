<?php

namespace Blueprint\Part;

class Headline extends Text {

  protected $headline;
  protected $inner;

  static function getTypes() {
    return array(
      'primary'
    );
  }

  function init() {
    parent::init();
    $this->setTag('h2');
  }

  function setPlaceholder($text=null) {
    if (!$text) {$text = 'Nemo enim ipsam voluptat.';}
    $this->placeholder = $text;
    return $this;
  }

  function setType($type) {
    $class = 'headline-' . $type;
    $this->setClass($class);
    $this->getInner()
      ->setClass($class . '__inner');
    return $this;
  }

}

// class HeadlineInner extends Part {
//
//   use HeadlineMethods;
//
//   function init() {
//     $this->setTag('span');
//   }
//
//   function buildInit() {
//     if (!$this->headline) {$this->setHeadline();}
//     $this->addHtml($this->headline);
//   }
//
// }

// trait HeadlineMethods {
//
//   protected $headline;
//
//   function setHeadline($headline=null) {
//     if (!$this->headline) {
//       diedump($this);
//       if (!empty($this->field['headline'])) {$headline = $this->field['headline'];}
//       elseif (is_string($this->field)) {$headline = $this->field;}
//       elseif ($this->name) {$headline = $this->name;}
//       else {$headline = 'Pellentesque habitant morbi.';}
//     }
//     $this->headline = $headline;
//     return $this;
//   }
//
// }
