<?php

namespace Blueprint\Template\Single;
use \Blueprint\Part as part;
use \Blueprint\Template as template;

// https://codex.wordpress.org/Function_Reference/register_post_type#Arguments

class Team extends template\Single {

function buildPostHeader() {
  parent::buildPostHeader();
  $img = (new part\Image())
    ->addClass('avatar-small post-header__avatar');
  $header = $this->getPostHeader();
  $header->insertPartBefore($img);

  $title = get_field('title');
  $company = get_field('company');
  if ($company) {$meta = "$title<br />$company";}
  else {$meta = "$title";}

  $header->addHtml("<p class='post-header__meta'>$meta</p>");
  $header->addSpacer();
  return $header;
}

function build() {
  return parent::build();
}

}
