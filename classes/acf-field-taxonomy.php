<?php

namespace Blueprint\Acf\Field;
use \Blueprint\acf as acf;

class Taxonomy extends acf\Field {

  protected $choices;

  protected function init() {
    $this->field['type'] = 'taxonomy';
    $this->setReturnFormat('object');
  }

  function setAddTerm($add) {
    $this->field['add_term'] = $add;
    return $this;
  }

  function setUi($type='checkbox') {
    $choices = array('checkbox','multi_select','radio','select');
    if (!in_array($type,$choices)) {wp_die('setFieldType invalid field type');}
    $this->field['field_type'] = $type;
    return $this;
  }

  function setReturnFormat($format='id') {
    $choices = array('id','object');
    $this->field['return_format'] = $format;
    return $this;
  }

  function setTaxonomy($taxonomy) {
    $this->field['taxonomy'] = $taxonomy;
    return $this;
  }

}
