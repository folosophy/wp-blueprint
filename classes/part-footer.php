<?php

namespace Blueprint\Part;

class Footer extends Part {

  function init() {

    $this->setTag('footer');
    $this->setId('footer');
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

  function build() {
    ob_start();
    wp_footer();
    $footer = ob_get_clean();
    $this->addHtml($footer);
    return parent::build();
  }

}

class FooterBar extends Part {

  protected $social;

  function init() {
    $this->setClass('footer-bar');
  }

  function addCopyright() {

    $part = $this->addItem()
      ->addClass('footer-bar__copyright');

      $part->addText('©' . date('Y') . ' ' . get_bloginfo('name'),true)
        ->setTag('div');

  }

  function addItem($name=null) {
    return $this->addPart()
      ->addClass('item ' . $name);
  }

  function addSignature($prepend,$author='Sherpa Design Co.') {

    $sig = $this->addItem()
      ->addHtml($prepend);

      $sig->addText($author,true)
        ->addClass('signature__author')
        ->setLink('http://sherpadesign.co');

  }

  function addSocial() {
    $part = $this->addItem()
      ->addClass('footer-bar__social');
    $field = get_field('main_social','option');
    foreach ($field as $account) {
      $platform = $account['platform'];
      $part
        ->addPart('item-social__wrap')
          ->setLink($account['link'])
        ->addIcon('social-' . $platform . '-white',true)
          ->setClass('footer-bar__social-item');
    }

  }

}
