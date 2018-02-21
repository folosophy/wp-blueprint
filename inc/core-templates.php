<?php

namespace Blueprint\Acf;

// Template

$template = (new Group('template'))
  ->setLocation('page')
  ->setLabelPlacement('top')
  ->setPosition('side');

  $template->addSelect('template')
    ->hideLabel()
    ->setAllowNull(true)
    ->setChoices(array(
      'default',
      'basic'
    ));

  $template->addTrueFalse('template_is_locked',true)
    ->setLabel('Locked');
