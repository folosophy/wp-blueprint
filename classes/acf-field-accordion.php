<?php

namespace Blueprint\Acf\Field;
use Blueprint\Acf as acf;

class Accordion extends acf\Field {

  function init() {
    $this->setType('accordion');
    $this->setEndpoint(false);
  }

  function setEndpoint($endpoint=false) {
    if (!is_bool($endpoint)) {wp_die('Accordion setEndpoint expects bool.');}
    $this->field['endpoint'] = $endpoint;
    return $this;
  }

  function setMultiExpand($multi=false) {
    if (!is_bool($multi)) {wp_die('Accordion setMultiExpand expects bool.');}
    $this->field['multi_expand'] = $multi;
    return $this;
  }

  function setOpen($open) {
    if (!is_bool($open)) {wp_die('Accordion setOpen expects bool.');}
    $this->field['open'] = $open;
    return $this;
  }

}
