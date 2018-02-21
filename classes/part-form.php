<?php

namespace Blueprint\Part;
use \Blueprint as bp;

class Form extends Part {

  function init() {
    $this->setTag('form');
    $this->setAttr('id','form-' . $this->name);
  }

  function addInputField($name=null,$chain=true) {
    $field = (new Input($name));
    return $this->addPart($field,$chain);
  }

  function addEmailField($name='email',$chain=false) {
    $field = (new Input($name))
      ->setType('email');
    return $this->addPart($field,$chain);
  }

  function addNameField($name=null,$chain=false) {
    $field = (new Input('name'));
    $el = $field->getFormElement()
      ->setTag('input');
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
    $field = (new Select($name,$this));
    return $this->addPart($field,$chain);
  }

  function addTextAreaField($name=null,$chain=false) {
    $title = ucwords(str_replace('_',' ',$name));
    if (!$name) {$name = 'message';}
    $field = (new Field($name));
    $el = $field->getFormElement()
      ->setTag('textarea')
      ->setAttr('name',$name)
      ->setAttr('rows',3);
    return $this->addPart($field,$chain);
  }

  function addTextField($name,$chain=false) {
    $placeholder = ucwords(str_replace('_',' ',$name));
    $field = (new Field($name));
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
    $field = (new Part('submit__wrap'))
      ->addClass('submit__wrap');
    $button = $field->addButton($name,$this);
    $button
      ->setType(false)
      ->setAttr('type','submit')
      ->setClass('button-submit');
    return $this->addPart($field,$chain);
  }

}

class Field extends Part {

  protected $formElement;

  function init() {
    if ($this->name) {
      $this->getFormElement()->setAttr('name',$this->name);
    }
    $this->addClass('field');
    $this->setLazy(true);
  }

  function getLabel() {
    if (!isset($this->label)) {$this->setLabel();}
    return $this->label;
  }

  function getFormElement() {
    if (!$this->formElement) {$this->setFormElement();}
    return $this->formElement;
  }

  function setFormElement() {
    $this->formElement = (new Part('',$this))
      ->addClass('element');
    return $this->formElement;
  }

  function setLabel($label=null) {

    if (!$label) {
      $label = ucwords(str_replace('_',' ',$this->name));
    }

    $this->label = (new Part())
      ->setTag('label')
      ->setAttr('for',$this->name)
      ->addHtml($label);

  }

  function setRequired($required=true) {
    $formEl = $this->getFormElement();
    if ($required) {$formEl->setAttr('required',null);}
    return $this;
  }

  function prepare() {

    $this->addPart($this->getLabel());

    $formEl = $this->getFormElement();
    $this->addClass('field field-' . $this->getFormElement()->tag);
    if (!isset($formEl->atts['required'])) {$this->setRequired(true);}
    $this->insertPart($this->getFormElement());
  }

}

class Select extends Field {

  protected $options;

  function init() {
    parent::init();
    $this->getFormElement()->setTag('select');
  }

  function addOption($key,$val=null) {
    if (!$val) {
      $val = ucwords(str_replace('_',' ',$key));
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

class Input extends Field {

  function init() {
    parent::init();
    $el = $this->getFormElement();
    $el->addClass('is-empty');
    $el->setTag('input');
  }

  function setType($type='text') {
    $this->setAttr('type',$type);
    return $this;
  }

}

class Option extends Part {

}

class Checkbox extends Field {



}
