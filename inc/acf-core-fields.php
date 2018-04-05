<?php

namespace Blueprint\Acf;

add_action('init',function() {
  do_action('bp/acf/filter_fields');
  do_action('bp/acf/register_fields');
});

// Hero

$g_hero = (new Group('hero'))
  ->setOrder('top')
  ->setPosition('high');

  $hero = $g_hero->addGroup('hero')
    ->setLayout('row');

      $hero->addSelect('content_type')
        ->setChoices(array(
          'default' => 'Default',
          'manual'  => 'Manual (Headline & Button)'
        ));


      $headline = $hl = $hero->addText('headline',true);

        $hl->getLogic()
          ->addCondition('content_type','default','!=');

      // $copy = $hero->addText('copy',true);
      //
      //   $copy->getLogic()
      //     ->addCondition('content_type','default','!=');

      $button = $hero->addButton('button',true);

        $button->getLogic()
          ->addCondition('content_type','default','!=');

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

// $featured_media = (new Group('featured_media'))
//   ->setPosition('side')
//   ->setLabelPlacement('top');
//
//   $fg_featured_media = $featured_media
//     ->addGroup('featured_media')
//       ->hideLabel(true)
//       ->setLayout('block');
//
//     apply_filters('bp/field/featured_media',$fg_featured_media);
//
//     $fg_featured_media
//       ->addSelect('format')
//         ->setChoices(array('image','video'))
//         ->end()
//       ->addImage('image',true)
//         ->setLabel('Image')
//         ->setLogic('format','image')
//         ->addSaveKey('_thumbnail_id')
//         ->end()
//       ->addVideo('video',true)
//         ->setLogic('format','video')
//         ->end();
//
//   apply_filters('bp_group_featured_media',$featured_media);

  // add_filter('acf/load_field/key=field_featured_media_image',function($val,$id) {
  //   return $val;
  // });

  // add_action('acf/load_field/key=field_featured_media_format',function($field) {
  //   var_dump($field);
  //   return $field;
  // },99999);

// Video

// $video = (new Group('video'))
//   ->addGroup('video')
//     ->addSelect('host')
//       ->setChoices(array('youtube'=>'YouTube','vimeo'))
//       ->setDefaultValue('youtube')
//       ->endSelect()
//     // YouTube ID
//     ->addText('youtube_id',true)
//       ->setLabel('Video ID')
//       ->setPrepend('watch?v=')
//       ->setPlaceholder('T-YqcuatM6I')
//       ->setLogic()
//         ->addCondition('host','youtube')
//         ->endLogic()
//       ->endText()
//     // Video ID
//     ->addText('vimeo_id',true)
//       ->setLabel('Video ID')
//       ->setPrepend('vimeo.com/')
//       ->setPlaceholder('227138298')
//       ->setLogic()
//         ->addCondition('host','vimeo')
//         ->endLogic()
//       ->endText()
//     ->addImage('thumbnail',true)
//       ->setRequired(0)
//       ->setInstructions('Optional')
//       ->end()
//     ->endGroup();

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



$site_info = (new Group('site_info'))
  ->setLocation('options_page','site-options')
  ->addGroup('site')
    ->addEmail('email');

$main_social = (new Group('main_social'))
  ->setLocation('options_page','site-options')
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
      ->setRequired(false)
      ->setPrepend('@');

$group_user = $gusr = (new Group('user'))
  ->setTitle('Basic Info')
  ->setPosition('high')
  ->setLocation('user_form','all');

  $user = $gusr->addGroup('user');

    $user->addImage('profile_photo',true)
      ->setRequired(false);

    //
    // $user->addText('first_name',true);
    //
    // $user->addText('middle_name',true)
    //   ->setRequired(0)
    //   ->end();
    //
    // $user->addText('last_name',true)
    //   ->addSaveKey('last_name');
    //
    // $user->addText('title');
    //
    // $user->addText('company');
    //
    // $user->addWysiwyg('bio');


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

$g_intro = (new Group('intro'))
  ->setPosition('high')
  ->setOrder('high');

  $intro = $g_intro ->addGroup('intro');

    $intro->addHeadline('headline',true);
    $intro->addCopy();

    $intro->addTrueFalse('button_enabled',true)
      ->setDebugId(1)
      ->setLabel('Enable Button')
      ->setRequired(false);

    $intro->addButton('button',true)
      ->setRequired(false)
      ->setLogic('button_enabled',true);

$editor = (new Group('editor'))
  ->setTitle('Post Content')
  ->setLocation('template','page')
  ->setLabelPlacement('top');

  $editor->addWysiwyg('editor',true)
    ->setMedia(true)
    ->addSaveKey('post_content','wp_posts');

  // add_filter('acf/load_value/key=field_editor',function($value) {
  //
  //   $post = get_post(get_the_ID());
  //   diedump($post);
  //   //if (!$value) {$value = get_the_content();}
  //   return $value;
  // });

// Events
// TODO: MTF Activate with events class, etc

$event_info = (new Group('event'))
  ->setTitle('Event Details')
  ->setLocation('event')
  ->setLayout('table')
  ->setLabelPlacement('left');

  $event = $event_info->addGroup('event');

    $event->addTab('about');

      $event->addTextArea('excerpt',true)
        ->addSaveKey('post_excerpt','wp_posts')
        ->setInstructions('A 1-2 sentence description of the event.');

    $event->addTab('date');

    $event->addTrueFalse('has_multiple_dates',true)
      ->setUi(false);

    $event->addDate('start_date',true)
      ->setLabel('Date')
      ->setLogic('has_multiple_dates',true,'!=');

    $dates = $event->addRepeater('dates',true)
      ->setMin(2)
      ->setButtonLabel('Add Date');

      $dates->getLogic()
        ->addCondition('has_multiple_dates',true);

      $dates->addDate('start_date',true)
        ->setLabel('Date');

    $event->addTab('time');

    $event->addTrueFalse('time_tbd',true)
      ->setLabel('Time TBD')
      ->setUi(false);

    $event->addTime('start_time',true)
      ->setRequired()
      ->setLogic('time_tbd',true,'!=')
      ->setLabel('Start Time');

    $event->addTime('end_time',true)
      ->setRequired()
      ->setLogic('time_tbd',true,'!=')
      ->setLabel('End Time');

    $event->addTab('location');

    $event->addSelect('location_type')
      ->setChoices(array(
        'address',
        'online',
        'tbd' => 'TBD',
      ));

    $address = $event->addGroup('address')
      ->setLayout('table')
      ->setLogic('location_type','address');

      $address->addText('venue',true)
        ->setRequired(false)
        ->setPlaceholder('*Optional');

      $address->addText('street',true)
        ->setPlaceholder('214 Example Road');

      $address->addText('city',true)
        ->setPlaceholder('Baltimore');

      $address->addText('state',true)
        ->setPlaceholder('Maryland');

  $event_cat = (new Group('event_category'))
    ->setTitle('Category')
    ->setLocation('event')
    ->setPosition('side')
    ->setLabelPlacement('top');

    $event_cat->addTaxonomy('event_category',true)
      ->setTaxonomy('event_category')
      ->setReturnFormat('object')
      ->setUi('radio');

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

$guest_author = (new Group('guest_author'));

  $guest_author
    ->addTrueFalse('is_guest_author',true)
      ->setLabel('Guest')
      ->setInstructions('Is this a guest author?');

  $field_guest_author = $guest_author
    ->addGroup('guest_author')
      ->addText('name')
      ->addText('email')
      ->addImage('image');

  $field_guest_author->setLogic('is_guest_author',true);

apply_filters('bp_group_guest_author',$guest_author);

$meta = (new Group('meta'));

  $m = $meta->addGroup('meta');

    $m->addTextarea('excerpt',true)
      ->addSaveKey('post_excerpt','wp_posts');

$g_ft_image = (new Group('featured_image'))
  ->setLabelPlacement('top')
  ->setPosition('side');

  $g_ft_image->addImage('featured_image',true)
    ->addSaveKey('_thumbnail_id','wp_postmeta');

  // add_filter('acf/load_value/key=field_featured_image',function($value,$id) {
  //   return $value;
  // });

////////////////////////////////////////////////////////
// OPTIONS
////////////////////////////////////////////////////////
