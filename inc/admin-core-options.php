<?php

namespace Blueprint;

$blueprint = (new OptionsPage('site_options'))
  ->setCapability('edit_posts')
  ->setRedirect(false)
  ->setIcon('schedule')
  ->addSubPage('footer');
