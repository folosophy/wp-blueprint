<?php

namespace Blueprint\Part;

class Footer extends Part {

  function init() {
    $this->setTag('footer');
    $this->addHtml("
      <div id='site-search'>
        <div id='site-search__wrap'>
          <form id='site-search__form'>
            <input id='site-search__input' type='text' placeholder='Search...' />
          </form>
        </div>
      </div>
    ");
  }

}
