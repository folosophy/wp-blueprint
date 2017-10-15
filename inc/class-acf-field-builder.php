<?php

namespace Blueprint\Acf;
use \Blueprint as bp;
use \Blueprint\Acf\Field as field;

trait FieldBuilder {

  function addField($field,$chain=false) {
    array_push($this->fields,$field);
    if ($chain) {return $field;}
    else {return $this;}
  }

  function addCheckbox($name) {
    $field = new Field\Checkbox($name,$this);
    return $field;
  }

  function addChoice($name,$chain=true) {
    $field = new Field\Checkbox($name,$this);
    addField($field);
    return $field;
  }

  function addClone($name,$key,$chain=false) {
    $field = (new Field\Duplicate($name,$this))
      ->addClone($key);
    return $this->addField($field,$chain);
  }

  function addCopy($name='copy',$chain=false) {
    $field = (new field\Wysiwyg($name,$this));
    return $this->addField($field);
  }

  function addHeadline($name='headline',$chain=false) {
    $field = (new Field\Text($name,$this))
      ->setMaxLength(60);
    array_push($this->fields,$field);
    if ($chain) {
      $this->currentField = $field;
      return $field;
    } else {return $this;}
  }

  function addGroup($name) {
    $field = new Field\Group($name,$this);
    return $this->addField($field,true);
  }

  function addImage($name,$chain=false) {
    $field = (new Field\Image($name,$this));
    return $this->addField($field,$chain);
  }

  function addSelect($name,$chain=true) {
    $field = new Field\Select($name,$this);
    return $this->addField($field,$chain);
  }

  function addTip($tip,$chain=false) {
    $tip = "<i>$tip</i>";
    $name = $this->name . '_message_' . count($this->fields);
    $field = (new Field\Message($name,$this))
      ->setMessage($tip)
      ->setLabel('👍 Helpful Tip');
    $this->addField($field);
    if (!$chain) {return $this;}
    else {return $field;}
  }

  function addMessage($message,$chain=false) {
    $name = $this->name . '_message_' . count($this->fields);
    $field = (new Field\Message($name,$this))
      ->setLabel($this->name)
      ->setMessage($message);
    return $this->addField($field,$chain);
  }

  function addPostObject($name,$chain=false) {
    $field = (new Field\PostObject($name,$this));
    return $this->addField($field,$chain);
  }

  function addPreset($preset) {
    $class = 'Blueprint\\Preset\\' . ucwords($preset);
    $preset = new $class();
  }

  function addText($name,$chain=false) {
    $field = (new Field\Text($name,$this));
    array_push($this->fields,$field);
    if ($chain) {
      $this->currentField = $field;
      return $field;
    } else {return $this;}
  }

  function addTextArea($name,$chain=false) {
    $field = (new Field\TextArea($name,$this));
    array_push($this->fields,$field);
    if ($chain) {
      $this->currentField = $field;
      return $field;
    } else {return $this;}
  }

  function addTrueFalse($name,$chain=false) {
    $field = (new Field\TrueFalse($name,$this));
    return $this->addField($field,$chain);
  }

  function addUrl($name,$chain=false) {
    $field = (new Field\Url($name,$this));
    array_push($this->fields,$field);
    return $this->addField($field,$chain);
  }

  function addVideo($name,$chain=false) {
    $field = $this->addGroup($name);
    $field
      ->addMessage('')
      ->addSelect('source')
        ->setChoices(array(
          'youtube' => 'YouTube',
          'vimeo'
        ))
        ->endSelect()
      ->addText('youtube_id',true)
        ->setLabel('Video ID')
        ->setLogic('source','youtube')
        ->setPrepend('youtube.com/watch?v=')
        ->setPlaceholder('AxG14lbL2Iw')
        ->endText()
      ->addText('vimeo_id',true)
        ->setLabel('Video ID')
        ->setPrepend('vimeo.com/')
        ->setPlaceholder('237748768')
        ->setLogic('source','vimeo')
        ->endText()
      ->addImage('thumbnail',true)
        ->setRequired(0)
        ->setInstructions('Optional');
    return $this;
  }

  function addWysiwyg($name,$chain=false) {
    $field = (new Field\Wysiwyg($name,$this));
    return $this->addField($field,$chain);
  }

  function setLayout($layout='block') {
    $layouts = array('block','table','row');
    if (in_array($layout,$layouts)) {
      if (property_exists($this,'group')) {$this->group['layout'] = $layout;}
      else {$this->field['layout'] = $layout;}
    }
    return $this;
  }

}