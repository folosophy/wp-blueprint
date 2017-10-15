<?php

namespace Blueprint\Acf;

$featured_media = (new Group('featured_media'))
  ->setPosition('high')
  // Featured Media Group
  ->addGroup('featured_media')
    ->setLayout('row')
    ->addSelect('format')
      ->setChoices(array('image','video'))
      ->end()
    ->addTip('Set the Featured Image on the right.',true)
      ->setLogic('format','image')
      ->end()
    ->addSelect('video_source')
      ->setChoices(array('youtube','vimeo'))
      ->setLogic('format','video')
      ->endSelect()
    // YouTube ID
    ->addText('youtube_id',true)
      ->setLabel('Link')
      ->setPrepend('youtube.com/watch?v=')
      ->setPlaceholder('T-YqcuatM6I')
      ->setLogic()
        ->addCondition('video_source','youtube')
        ->andCondition('format','video')
        ->endLogic()
      ->endText()
    // Video ID
    ->addText('vimeo_id',true)
      ->setLabel('Link')
      ->setPrepend('vimeo.com/')
      ->setPlaceholder('227138298')
      ->setLogic()
        ->addCondition('video_source','vimeo')
        ->andCondition('format','video')
        ->endLogic()
      ->endText()
    ->endGroup()
  ->setLabelPlacement('top')
  ->setLocation(apply_filters('bp_featured_media_location','post'));

// Hero

$hero = (new Group('hero'))
  ->setOrder('high')
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
        ->addCondition('content_type','manual')
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
  ->setLayout('block')
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

do_action('bp/acf/after_core');
