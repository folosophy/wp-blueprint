<?php

namespace Blueprint\Theme;

trait Settings {

  static function getMainPages() {
      $tag = 'bp_main_pages';
      $pages = apply_filters($tag,'');
      return $pages;
    }

  static function getPostFormats($type='post') {
      $tag = 'bp_' . $type . '_formats';
      $formats = apply_filters($tag,'');
      return $formats;
    }



}
