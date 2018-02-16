<?php

namespace Blueprint\Part;

class WalkerMenuMain extends \Walker {

	public $db_fields = array('parent'=>'menu_item_parent','id'=>'db_id');

  // Start Level
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "<ul class='menu-main__sub-menu'>";
	}

  // End Level
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "</ul>";
	}

  // Start Element
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $title = $item -> title;
    $url = $item -> url;
		$expand = null;
		$target = $item -> target;
    // Add attributes
    if ($depth == 0) {
			$class = 'menu-main__item';
			$title_class = 'menu-main__item__title';
			//$expand "<div class='menu-main__item__expand-icon'>+</div>";
		} else {
			$class = 'menu-main__sub-item';
			$title_class = 'menu-main__sub-item__title';
		}
    // Render menu item
    $output .= "
      <li class='$class'>
        <a href='$url' target='$target'>
          <div class='$title_class'>
						$title
						$expand
					</div>
        </a>
    ";
	}

	// End Element
	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$output .= "</li>";

	}

} // Walker_Nav_Menu
