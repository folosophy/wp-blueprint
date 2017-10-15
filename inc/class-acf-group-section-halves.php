<?php

namespace Blueprint\Acf;

class Group_SectionHalves extends Group {

  function __construct($name) {
    parent::__construct($name);
    $field = new Field_Clone($name,array('field_5972338fadc60'));
    $this->addField(
      $field->getField()
    );
  }

}
