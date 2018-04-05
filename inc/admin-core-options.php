<?php

namespace Blueprint;

$site_options = $so = (new OptionsPage('site_options'))
  ->setCapability('edit_posts')
  ->setRedirect(false)
  ->setIcon('schedule');

$chapters = (new OptionsPage('social'))
  ->setLabel('Social')
  ->setParent('site-options');
