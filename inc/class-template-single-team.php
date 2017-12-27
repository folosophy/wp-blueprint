<?php

namespace Blueprint\Template\Single;
use \Blueprint\Part as part;
use \Blueprint\Template as template;

// https://codex.wordpress.org/Function_Reference/register_post_type#Arguments

class Team extends template\Single {

function setPostHeader() {
  $header = parent::setPostHeader();
  $img = (new part\Image())
    ->addClass('avatar-small');
  $header->prependPart($img);

  $title = get_field('title');
  $company = get_field('company');
  if ($company) {$meta = "<b>$title</b><br />$company";}
  else {$meta = "<b>$title</b>";}

  $header->addHtml("<p>$meta</p>");
  $header->addVideo('video',true);
  $header->addSpacer();
  return $header;
}

function setCategory() {
  $this->category = (new part\Part())
    ->setTag('h4')
    ->addHtml(get_field('company'));
  return $this->category;
}

}
