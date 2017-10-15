<?php

namespace Blueprint;

function log_post($id=null) {
  if (!$id) {$id = get_the_id();}
  if (!isset($GLOBALS['bp_post_log'])) {$GLOBALS['bp_post_log'] = array();}
  array_push($GLOBALS['bp_post_log'],$id);
}

function get_post_log() {
  return $GLOBALS['bp_post_log'];
}
