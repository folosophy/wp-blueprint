<?php

namespace Blueprint\Acf;
use \Blueprint as bp;
use \Blueprint\Acf\Field as field;

trait FieldBuilder {

  function addAccordion($name,$chain=false) {
    $label = $name;
    $name = 'accordion_' . rand();
    $field = (new field\Accordion($name,$this))
      ->setLabel($label);
    return $this->addField($field,$chain);
  }

  function addField($field,$chain=false) {
    array_push($this->fields,$field);
    if ($chain) {return $field;}
    else {return $this;}
  }

  // TODO: Check if is in field group
  // Otherwise, need way to prefix 'button'
  function addButton($name='button',$chain=false) {

    if (!$name) {$name = 'button';}

    $field = (new Field\Group($name,$this));

    $field->addText('label');

    $link_type = $field->addSelect('link_type')
      ->setWidth('40%')
      ->setChoices(array(
        'external' => 'External (Another Website)',
        'internal' => 'Internal (Your Website)',
        'section'
      ));

    $external_link = $field->addUrl('external_link',true)
      ->setLogic('link_type','external');

    $internal_link = $field->addPostObject('internal_link',true)
      ->setLogic('link_type','internal');

    $section_link = $field->addText('section_link',true)
      ->setLabel('Section Name')
      ->setPlaceholder('contact')
      ->setLogic('link_type','section');

    $link_fields = array(
      $external_link,
      $internal_link,
      $section_link
    );

    foreach ($link_fields as $link_field) {
      $link_field->setWidth('60%');
    }

    return $this->addField($field,$chain);

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

  function addClone($name,$clone_key,$chain=false) {
    // clone_key must be prefixed with field_ or group_
    $field = (new Field\Duplicate($name,$this))
      ->setDisplay('seamless')
      ->addClone($clone_key);
    return $this->addField($field,$chain);
  }

  function addCopy($name='copy',$chain=false) {
    $field = (new field\Wysiwyg($name,$this));
    return $this->addField($field,$chain);
  }

  function addDate($name,$chain=false) {
    $field = (new field\DatePicker($name,$this));
    return $this->addField($field,$chain);
  }

  function addDateTime($name,$chain=false) {
    $field = (new field\DateTimePicker($name,$this));
    return $this->addField($field,$chain);
  }

  function addEmail($name,$chain=false) {
    $field = (new field\Email($name,$this));
    return $this->addField($field,$chain);
  }

  function addFile($name,$chain=false) {
    $field = (new field\File($name,$this));
    return $this->addField($field,$chain);
  }

//   function addGoogleMap($name,$chain=false) {
//   $field = (new field\GoogleMap($name,$this));
//   return $this->addField($field,$chain);
// }

  function addFlexibleContent($name,$chain=true) {
    $field = (new field\FlexibleContent($name,$this));
    return $this->addField($field,$chain);
  }

  function addGroup($name) {
    $field = new Field\Group($name,$this);
    return $this->addField($field,true);
  }

  function addHeadline($name='headline',$chain=false) {
    $field = (new Field\Text($name,$this))
      ->setMaxLength(100);
    array_push($this->fields,$field);
    if ($chain) {
      $this->currentField = $field;
      return $field;
    } else {return $this;}
  }

  function addIconSelect($name='icon',$chain=true) {
    $field = (new Field\IconSelect($name,$this));
    return $this->addField($field,$chain);
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

  function addNumber($name,$chain=false) {
    $field = (new Field\Number($name,$this));
    return $this->addField($field,$chain);
  }

  function addPostObject($name,$chain=true) {
    $field = (new Field\PostObject($name,$this));
    return $this->addField($field,$chain);
  }

  function addPreset($preset) {
    $class = 'Blueprint\\Preset\\' . ucwords($preset);
    $preset = new $class();
  }

  function addRange($name,$chain=false) {
    $field = (new Field\Number($name,$this))
      ->setType('range');
    return $this->addField($field,$chain);
  }

  function addRepeater($name) {
    $field = (new Field\Repeater($name,$this));
    return $this->addField($field,true);
  }

  function addStats($name='stats',$chain=false) {
    $field = $this->addRepeater($name,$chain);
      $field->addNumber('number',true)
        ->setPlaceholder('300');
      $field->addSelect('number_type')
        ->setChoices(array(
          'default',
          'percent' => '%'
        ));
      $field->addText('title',true)
        ->setPlaceholder('Participants');
      $field->addText('description');
    return $this->addField($field,$chain);
  }

  function addTab($name,$chain=false) {
    $field = (new Field\Tab($name,$this));
    return $this->addField($field,$chain);
  }

  function addTaxonomy($name,$chain=false) {
    $field = (new field\Taxonomy($name,$this));
    return $this->addField($field,$chain);
  }

  function addText($name,$chain=false) {
    $field = (new Field\Text($name,$this));
    return $this->addField($field,$chain);
  }

  function addTextArea($name,$chain=false) {
    $field = (new Field\TextArea($name,$this));
    array_push($this->fields,$field);
    if ($chain) {
      $this->currentField = $field;
      return $field;
    } else {return $this;}
  }

  function addTime($name,$chain=false) {
    $field = (new field\DateTimePicker($name,$this))
      ->setDisplayFormat('g:i a')
      ->setReturnFormat('g:i a')
      ->setType('time_picker');
    return $this->addField($field,$chain);
  }

  function addTrueFalse($name,$chain=false) {
    $field = (new Field\TrueFalse($name,$this));
    return $this->addField($field,$chain);
  }

  function addUrl($name,$chain=false) {
    $field = (new Field\Url($name,$this));
    return $this->addField($field,$chain);
  }

  function addVideo($name='video',$chain=false) {
    $field = (new Field\Video($name,$this));
    return $this->addField($field,$chain);
    return $field;
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
