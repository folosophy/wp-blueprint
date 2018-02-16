<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class Form extends Part {

  function init() {
    $this->setTag('form');
    $this->setAttr('id','form-' . $this->name);
  }

  function addEmailField($name=null,$chain=false) {
    if (!$name) {$name = 'email';}
    $field = (new Field());
    $el = $field->getFormElement()
      ->setTag('input')
      ->setAttr('name',$name)
      ->setAttr('placeholder','Your Email');
    return $this->addPart($field,$chain);
  }

  function addNameField($name=null,$chain=false) {
    if (!$name) {$name = 'name';}
    $field = (new Field());
    $el = $field->getFormElement()
      ->setTag('input')
      ->setAttr('name',$name)
      ->setAttr('placeholder','Your Name');
    return $this->addPart($field,$chain);
  }

  function addSearchField($name=null,$chain=false) {
    if (!$name) {$name = 'search';}
    $field = (new Field())
      ->addClass('search-bar');
    $icon = $field
      ->addPart('')
        ->setClass('search-bar__submit')
        ->addIcon('search')
          ->setClass('search-bar__submit-icon');
    $formEl = $field
      ->setFormElement()
        ->setTag('input')
        ->setAttr('type','search')
        ->setAttr('name',$name)
        ->setAttr('placeholder','Search...');
    return $this->addPart($field,$chain);
  }

  function addSelectField($name,$chain=true) {
    if (!$name) {$name = 'name';}
    $field = (new Select($name,$this));
    $el = $field->getFormElement()
      ->setTag('select')
      ->setAttr('name',$name);
    return $this->addPart($field,$chain);
  }

  function addTextAreaField($name=null,$chain=false) {
    $title = ucwords(str_replace('_',' ',$name));
    if (!$name) {$name = 'message';}
    $field = (new Field());
    $el = $field->getFormElement()
      ->setTag('textarea')
      ->setAttr('name',$name)
      ->setAttr('placeholder','Your Message...')
      ->setAttr('rows',3);
    return $this->addPart($field,$chain);
  }

  function addTextField($name,$chain=false) {
    $placeholder = ucwords(str_replace('_',' ',$name));
    $field = (new Field());
    $el = $field->getFormElement()
      ->setTag('input')
      ->setAttr('name',$name)
      ->setAttr('placeholder',$placeholder);
    return $this->addPart($field,$chain);
  }

  function addField($part,$chain=true) {
    $field = (new Part($name))
      ->setClass('field')
      ->addPart();
    return $this->addPart($field,$chain);
  }

  function addSubmit($name=null,$chain=false) {
    if (!$name) {$name = 'name';}
    $field = (new Button($name,$this));
    $field
      ->setType(false)
      ->setAttr('type','submit')
      ->setAttr('href',false)
      ->setTag('button')
      ->setLabel($name)
      ->setClass('form__submit');
    return $this->addPart($field,$chain);
  }

}

class Field extends Part {

  protected $formElement;

  function init() {
    $this->addClass('field');
    $this->setLazy(true);
  }

  function getFormElement() {
    if (!$this->formElement) {$this->setFormElement();}
    return $this->formElement;
  }

  function setFormElement() {
    $this->formElement = new Part('',$this);
    return $this->formElement;
  }

  function setRequired($required=true) {
    $formEl = $this->getFormElement();
    if ($required) {$formEl->setAttr('required',null);}
    return $this;
  }

  function prepare() {
    $formEl = $this->getFormElement();
    $this->addClass('field-' . $this->tag);
    if (!isset($formEl->atts['required'])) {$this->setRequired(true);}
    $this->insertPart($this->getFormElement());
  }

}

class Select extends Field {

  protected $options;

  function addOption($key,$val=null) {
    if (is_int($key)) {
      $key = $val;
      $val = ucwords(str_replace('_',' ',$val));
    }
    $option = "<option value='$key'>$val</option>";
    $this->getFormElement()->addHtml($option);
    return $this;
  }

  function addOptions($options) {
    if (!is_array($options)) {wp_die('Select Field addOptions expects array.');}
    foreach ($options as $key => $val) {
      $this->addOption($key,$val);
    }
    return $this;
  }

  function setPlaceholder($key,$val=null) {
    // TODO: rewrite to part
    if (!$val) {
      $val = ucwords(str_replace('_',' ',$key));
    }
    $option = "<option value='$key' selected disabled>$val</option>";
    $this->getFormElement()->addHtml($option);
    return $this;
  }

}

class Input extends Part {

  function init() {

  }

}

class Option extends Part {

}

class Checkbox extends Field {



}
