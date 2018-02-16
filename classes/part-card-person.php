<?php

namespace Blueprint\Part\Card;
use \Blueprint\Part as part;

class Person extends part\Part {

  protected $cardType;
  protected $postId; // TODO: integrate with part/card
  protected $quote;

  function init() {
    $this->quote = get_field('quote',$this->postId);
  }

  function buildFeatured() {
    $this->part = "
      <q>$this->quote</q>
    ";
  }

  function buildInit() {
    $this->buildFeatured();
  }

}

$dames_field = get_field('featured_dames');
$dame = get_post($dames_field['featured_dame']);
$id = $dame->post_id;
$name = get_field('first_name',$id) . ' ' . get_field('last_name',$id);
$img = bp_get_img('avatar-md');
$bio = get_field('bio',$id);
$quote = get_field('quote',$id);
$dames = '';
$dames .= "
  <q>$quote</q>
  <div class='card-ft-team'>
    <div class='card-ft-team__img'>
      $img
    </div>
    <div class='info'>
      <h4>Great Dame</h4>
      <h3>$name</h3>
      <p class='last'>$bio</p>
    </div>
  </div>
";
