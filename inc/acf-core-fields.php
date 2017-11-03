<?php

namespace Blueprint\Acf;

$featured_media = (new Group('featured_media'))
  ->setPosition('high')
  ->setLabelPlacement('top')
  // Featured Media Group
  ->addGroup('featured_media')
    ->setLayout('row')
    ->addSelect('format')
      ->setChoices(array('image','video'))
      ->end()
    ->addTip('Set the Featured Image on the right.',true)
      ->setLogic('format','image')
      ->end()
    ->addClone('video','field_video',true)
      ->setDisplay('group')
      ->setLogic('format','video')
      ->end()
    ->endGroup()
  ->setLocation(apply_filters('bp_featured_media_location',array('post')));

// Video

$video = (new Group('video'))
  ->addGroup('video')
    ->addSelect('source')
      ->setChoices(array('youtube'=>'YouTube','vimeo'))
      ->setDefaultValue('youtube')
      ->endSelect()
    // YouTube ID
    ->addText('youtube_id',true)
      ->setLabel('Link')
      ->setPrepend('youtube.com/watch?v=')
      ->setPlaceholder('T-YqcuatM6I')
      ->setLogic()
        ->addCondition('source','youtube')
        ->endLogic()
      ->endText()
    // Video ID
    ->addText('vimeo_id',true)
      ->setLabel('Link')
      ->setPrepend('vimeo.com/')
      ->setPlaceholder('227138298')
      ->setLogic()
        ->addCondition('source','vimeo')
        ->endLogic()
      ->endText()
    ->endGroup();

// Hero

$hero = (new Group('hero'))
  ->setOrder('top')
  ->addGroup('hero')
    ->addSelect('content_type')
      ->setChoices(array(
        'default' => 'Default',
        'manual'  => 'Manual (Headline & Button)',
        'post_select' => 'Select a Post'
      ))
      ->endSelect()
    // Headline
    ->addText('headline',true)
      ->setLogic()
        ->addCondition('content_type','post_select')
        ->endLogic()
      ->end()
    ->addPostObject('post_select',true)
      ->setInstructions('S')
      ->setLogic('content_type','post_select')
      ->end()
    ->addText('button_label',true)
      ->setLabel('Button Label')
      ->setPlaceholder('Defaults to "Learn More"')
      ->setLogic('content_type','manual')
      ->endText()
  ->endGroup()
  ->setLocation('page');

$main_social = (new Group('main_social'))
  ->setLocation('site_options','options_page')
  ->addRepeater('main_social')
    ->setButtonLabel('Add an account')
    ->setLabel('Accounts')
    ->addSelect('platform')
      ->setChoices(array(
        'facebook',
        'twitter',
        'linkedin'
      ))
      ->endSelect()
    ->addUrl('link')
    ->addText('handle',true)
      ->setPrepend('@');

$text_elements = (new Group('text_elements'))
  ->addText('headline')
  ->setLocation('post');

$form_elements = (new Group('personal_info'))
  ->addText('first_name')
  ->addText('middle_name',true)
    ->setRequired(0)
    ->end()
  ->addText('last_name')
  ->addText('title')
  ->addText('company')
  ->addTextArea('bio')
  ->setLocation('blog');

// Events
// TODO: MTF Activate with events class, etc

$event_info = (new Group('event_info'))
  ->addDateTime('start_date',true)
    ->setLabel('Starts')->end()
  ->addDateTime('end_date',true)
    ->setLabel('ends')->end()
  ->setLocation('event')
  ->setLayout('table')
  ->setLabelPlacement('left');

$intro = (new Group('intro'))
  ->addGroup('intro')
    ->addHeadline()
    ->addCopy()
    ->end()
  ->setLocation('page')
  ->setOrder('high');

do_action('bp/acf/after_core');
