<?php

namespace Blueprint\Builder;

class LocationBuilder extends Builder {

  protected function setLocation($name,$operator,$value) {
    return [
      'param' => $name,
      'operator' => $operator,
      'value' => $value
    ];
  }

}
