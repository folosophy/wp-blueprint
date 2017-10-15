<?php

namespace Blueprint;

$blueprint = (new OptionsPage('site_options'))
  ->setCapability('edit_posts')
  ->setIcon('schedule');
