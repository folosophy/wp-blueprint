<?php

namespace Blueprint\Part;

class Showcase extends Part {

  protected $fieldShowcase;
  protected $items;

  function __construct($name) {
    $this->setFields($name);
    $this->setItems($name);
  }

  private function setFields($name) {
    $field = get_field($name . '_showcase');
    $this->fieldShowcase = $field;
  }

  private function setItems() {
    foreach ($this->fieldShowcase as $item) {
      $headline  = $item['headline'];
      $paragraph = strip_tags($item['paragraph'],'<b><a>');
      // TODO: add image option
      $img = ps_get_theme_img($item['icon'],'icon-md');
      $this->items .= "
        <div class='col-3 showcase-item'>
          <a href='#help'>
            <div>
              $img
              <hr class='spacer-sm' />
              <h3>$headline</h3>
              <p class='p2'>$paragraph</p>
            </div>
          </a>
        </div>
      ";
    }
  }

  private function setPostItems() {
    $posts = get_field('')
    foreach ()
  }

  function build() {
    return "
      <div class='grid showcase'>
        $this->items
      </div>
    ";
  }

}
