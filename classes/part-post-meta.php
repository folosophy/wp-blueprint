<?php

namespace Blueprint\Part;

class PostMeta extends Part {

  function buildInit() {

    $author_id        = get_the_author_meta('ID');
    $user_id          = 'user_' . $author_id;
    $author_fname     = get_the_author_meta('first_name');
    $author_lname     = get_the_author_meta('last_name');
    $author_name      = $author_fname . ' ' . $author_lname;
    $author_img       = bp_get_avatar($author_id,'icon-md avatar');
    $author_company   = get_field('user_company',$user_id);
    $author_title     = get_field('user_title',$user_id);

    $contributor      = user_can($user_id,'contributor');
    $post_date        = get_the_date('F j, Y');
    $author_link_text = 'sherpadesign.co';
    $author_link      = get_field('user_website',$user_id);

    if ($author_link) {
      $author_site_text = parse_url($author_link);
      $author_site_text = $author_site_text['host'];
      $author_website   = "<a href='$author_link'>$author_site_text</a>";
    } else {
      $author_website = '';
    }

    $this->part = "
      <div class='container-sm'>
        <div class='grid mbtb-center'>
          <div class='col-2'>
            $author_img
          </div>
          <div class='col-2'>
            <h4>$author_company</h4>
            <h5>$author_name</h5>
            <p class='p2 last'>
              $post_date<br />
              $author_website
            </p>
          </div>
        </div>
        <hr class='spacer-md' />
      </div>
    ";

  }

}
