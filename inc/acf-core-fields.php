<?php

namespace Blueprint\Acf;

$date_elements = (new Group('date_elements'))
  ->addSelect('dotw')
    ->setLabel('Day of the Week')
    ->setChoices(array(
      'Monday',
      'Tuesday',
      'Wednesday',
      'Thursday',
      'Friday',
      'Saturday',
      'Sunday'
    ))
    ->end();

$featured_media = (new Group('featured_media'))
  ->setPosition('high')
  ->setLabelPlacement('left')
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
      ->setLogic('featured_media_format','video')
      ->end()
    ->endGroup()
    //->dumpFields()
  ->setLocation(apply_filters('bp_featured_media_location',array('post')));

// Video

$video = (new Group('video'))
  ->addGroup('video')
    ->addSelect('host')
      ->setChoices(array('youtube'=>'YouTube','vimeo'))
      ->setDefaultValue('youtube')
      ->endSelect()
    // YouTube ID
    ->addText('youtube_id',true)
      ->setLabel('Link')
      ->setPrepend('youtube.com/watch?v=')
      ->setPlaceholder('T-YqcuatM6I')
      ->setLogic()
        ->addCondition('host','youtube')
        ->endLogic()
      ->endText()
    // Video ID
    ->addText('vimeo_id',true)
      ->setLabel('Link')
      ->setPrepend('vimeo.com/')
      ->setPlaceholder('227138298')
      ->setLogic()
        ->addCondition('host','vimeo')
        ->endLogic()
      ->endText()
    ->addImage('thumbnail',true)
      ->setRequired(0)
      ->setInstructions('Optional')
      ->end()
    ->endGroup();

    // ->addMessage('')
    // ->addSelect('source')
    //   ->setChoices(array(
    //     'youtube' => 'YouTube',
    //     'vimeo'
    //   ))
    //   ->endSelect()
    // ->addText('youtube_id',true)
    //   ->setLabel('Video ID')
    //   ->setLogic('source','youtube')
    //   ->setPrepend('youtube.com/watch?v=')
    //   ->setPlaceholder('AxG14lbL2Iw')
    //   ->endText()
    // ->addText('vimeo_id',true)
    //   ->setLabel('Video ID')
    //   ->setPrepend('vimeo.com/')
    //   ->setPlaceholder('237748768')
    //   ->setLogic('source','vimeo')
    //   ->endText()

    // return $this;

// Hero

$hero = (new Group('hero'))
  ->setOrder('top')
  ->setLocation('page');

$hero_group = $hero->addGroup('hero')
  ->setLayout('row');

$hero_group
  ->addSelect('content_type')
    ->setChoices(array(
      'default' => 'Default',
      'manual'  => 'Manual (Headline & Button)',
      'post_select' => 'Select a Post'
    ));

$hero_group
  ->addText('headline',true)
    ->setLogic()
      ->addCondition('content_type','default','!=')
      ->endLogic()
    ->end();

$hero_group
  ->addPostObject('post_select',true)
    ->setLogic('content_type','post_select')
    ->end();

$hero_group
  ->addText('button_text',true)
    ->setLabel('Button Text')
    ->setPlaceholder('Defaults to "Learn More"')
    ->setLogic()
      ->addCondition('content_type','post_select')
      ->endLogic()
    ->end();

$hero_group
  ->addButton('button',true)
    ->setLogic()
      ->addCondition('content_type','manual')
      ->endLogic()
    ->end();

$site_info = (new Group('site_info'))
  ->setLocation('site-options','options_page')
  ->addGroup('site')
    ->addEmail('email');

$main_social = (new Group('main_social'))
  ->setLocation('site-options','options_page')
  ->addRepeater('main_social')
    ->setButtonLabel('Add an account')
    ->setLabel('Accounts')
    ->addSelect('platform')
      ->setChoices(array(
        'facebook',
        'instagram',
        'linkedin' => 'LinkedIn',
        'shopify',
        'twitter'
      ))
      ->endSelect()
    ->addUrl('link')
    ->addText('handle',true)
      ->setPrepend('@');

$text_elements = (new Group('text_elements'))
  ->addText('headline')
  ->setLocation('post');

$personal_info_elements = (new Group('personal_info'))
  ->addImage('profile_photo')
  ->addText('first_name')
  ->addText('middle_name',true)
    ->setRequired(0)
    ->end()
  ->addText('last_name')
  ->addText('title')
  ->addText('company')
  ->addWysiwyg('bio')
  ->setLocation('');

$intro = (new Group('intro'))
  ->addGroup('intro')
    ->addHeadline()
    ->addCopy()
    ->addButton()
    ->end()
  ->setLocation('page')
  ->setOrder('high');

// Events
// TODO: MTF Activate with events class, etc

$event_info = (new Group('event_info'))
  ->addGroup('event')
    ->addAccordion('Time',true)
      ->setOpen(false)->end()
    ->addDateTime('start',true)
      ->setLabel('Starts')->end()
    ->addDateTime('end',true)
      ->setLabel('ends')->end()
    ->addAccordion('Location')
    ->addGroup('address')
      ->addText('street',true)
        ->setPlaceholder('214 Example Road')->end()
      ->addText('city',true)
        ->setPlaceholder('Baltimore')->end()
      ->addText('state',true)
        ->setPlaceholder('Maryland')->end()
      ->addText('zip',true)
        ->setPlaceholder('12345')->end()
      ->setLayout('table')
      ->end()
    ->end()
  ->setLocation('event')
  ->setLayout('table')
  ->setLabelPlacement('left');

do_action('bp/acf/after_core');

$form_elements = (new Group('form_elements'))
  ->addGroup('button')
    ->addText('label')
    ->addSelect('link_type')
      ->setChoices(array(
        'internal',
        'external'
      ))
      ->end()
    ->addUrl('external_link',true)
      ->setLogic('button_link_type','external')
      ->end()
    ->addPostObject('internal_link',true)
      ->setLogic('button_link_type','internal')
      ->end();

// $iframe_elements = (new Group('iframe_elements'))
//   ->

// $post_content = (new Group('post_content'))
//   ->addFlexibleContent('post_content')
//     ->setButtonLabel('Add Content')
//     // Layouts
//     ->addLayout('paragraph')
//       ->addWysiwyg('text')
//       ->end()
//     ->end()
//   ->setLocation('article');
