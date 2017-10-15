<?php

// Custom Toolbars
function bp_wysiwyg_toolbars($toolbars) {

  $toolbars['Simple'] = array();
  $toolbars['Simple'][1] = array('bold','italic','underline','link','unlink');
  return $toolbars;

} add_filter('acf/fields/wysiwyg/toolbars','bp_wysiwyg_toolbars');
