<?php

namespace Blueprint\Acf\Field;

class Video extends Group {

  function init() {
    parent::init();
    $this->addDefaultFields();
  }

  protected function addDefaultFields() {
    $this
      ->addSelect('host')
        ->setChoices(array('youtube'=>'YouTube','vimeo'))
        ->setDefaultValue('youtube')
        ->endSelect()
      // YouTube ID
      ->addText('youtube_id',true)
        ->setLabel('Video ID')
        ->setPrepend('watch?v=')
        ->setPlaceholder('T-YqcuatM6I')
        ->setLogic()
          ->addCondition('host','youtube')
          ->endLogic()
        ->endText()
      // Video ID
      ->addText('vimeo_id',true)
        ->setLabel('Video ID')
        ->setPrepend('vimeo.com/')
        ->setPlaceholder('227138298')
        ->setLogic()
          ->addCondition('host','vimeo')
          ->endLogic()
        ->endText()
      ->addImage('thumbnail',true)
        ->setRequired(0)
        ->setInstructions('Optional')
        ->end();
  }

}
