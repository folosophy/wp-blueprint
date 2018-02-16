<?php

namespace Blueprint;

class GoogleAnalytics {

  protected $id;

  function __construct($id) {
    $this->id = $id;
    add_action('wp_head',array($this,'render'),-99999);
  }

  function render() {
    echo "
      <!-- Global Site Tag (gtag.js) - Google Analytics -->
      <script async src='https://www.googletagmanager.com/gtag/js?id=$this->id'></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments)};
        gtag('js', new Date());

        gtag('config', '$this->id');
      </script>
    ";
  }

}
