<?php

namespace Blueprint\Part;

class Footer extends Part {

  function init() {
    $this->setTag('footer');
    $this->addHtml("
      <div id='site-search'>
        <div id='site-search__wrap'>
          <form id='site-search__form' class='form-site-search'>
            <input id='site-search__input' type='search' type='text' autocomplete='off' placeholder='Search...' />
          </form>
        </div>
      </div>
    ");
  }

  function addFooterBar() {
    $part = (new FooterBar());
    return $this->addPart($part,true);
  }

}

class FooterBar extends Part {

  protected $social;

  function init() {
    $this->setClass('footer-bar');
  }

  function addCopyright() {
    $part = (new Text('©' . date('Y') . ' ' . get_bloginfo('name')))
      ->setClass('footer-bar__copyright')
      ->setTag('div');
    $this->addPart($part,false);
  }

  function addSocial() {
    $part = (new Part())
      ->setClass('footer-bar__social');
    $field = get_field('main_social','option');
    foreach ($field as $account) {
      $platform = $account['platform'];
      $part->addIcon('social-' . $platform . '-white',true)
        ->setClass('footer-bar__social-item');
    }
    return $this->addPart($part,false);
  }

}
