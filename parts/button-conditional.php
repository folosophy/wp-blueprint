<?php

namespace Blueprint\Part;

class ButtonConditional extends Part {

  protected $groupName;
  protected $button;

  function __construct($groupName) {
    $this->groupName = $groupName;
    $this->setButton();
  }

  protected function setButton() {
    $target  = $this->getGroupField('button_link_type');
    $label   = $this->getGroupField('button_label');
    $newTab  = null;
    $options = $this->getGroupField('options');
    if (in_array('button',$options)) {
      switch ($target) :
        case ('external') :
          $link = $this->getGroupField('button_external_link');
          $newTab = true; break;
        case ('internal') : $link = get_permalink($this->getGroupField('button_internal_link')); break;
        case ('phone')    :
          $num  = getGroupField('button_phone_number');
          $num  = '(' . substr($num,0,3) . ') ' . substr($num,3,3) . '-' . substr($num,6,9);
          $link = 'tel:' . $num; break;
        default : $link = null;
      endswitch;
      $button = new Button();
      $button
        ->setStyle('light')
        ->setLabel($label)
        ->setLink($link)
        ->setnewTab($newTab);
      $this->button = $button->build();
    }
  }

  public function build() {
    return $this->button;
  }

}
