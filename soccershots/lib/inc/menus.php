<?php
/* CUSTOM MENU OUTPUT */
function soccershots_custom_menu($menu_name = '', $markup_name = '', $menu_id = '', $menu_classes = '') {
	if ($menu_name != '' && ($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$m = '';
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$pageid = get_the_ID();

		switch ($markup_name) {
			/* CORPORATE: MAIN MENU */
			case 'corporate-main-menu':
				$m .= '<ul id="' . $menu_id . '" class="' . $menu_classes . '">' . "\n";
				foreach ((array) $menu_items as $key => $menu_item) {
					$title      = $menu_item->title;
					$url        = $menu_item->url;
					$target     = $menu_item->target;
					$targetAttr = '';
					$classes    = $menu_item->classes;
					$cssClasses = '';
					$object_id  = $menu_item->object_id;
					$activeClass= '';



					if ($pageid == $object_id) {
						$activeClass = ' class="active"';
					}
					if ($target != '') {
						$targetAttr = ' target="' . $target . '"';
					}
					if ($classes[0] != '') {
						$sep = '';

						foreach ($classes as &$value) {
							$cssClasses .= $sep . $value;
							$sep = ' ';
						}
					}

					$m .= '<li>' . "\n";
					$m .= '<a href="' . $url . '"' . $targetAttr . $activeClass . '>' . "\n";
					$m .= $title . "\n";
					if ($cssClasses != '') {
						$m .= '<span class="' . $cssClasses . '"></span>' . "\n";
					}
					$m .= '</a>' . "\n";

					if ($cssClasses != '') {
						$m .= '<div class="dropdown">' . "\n";
						$m .= '<div class="dropdown-inner">' . "\n";
						$m .= '<div class="dropdown-loader"></div>' . "\n";
						$m .= '</div>'. "\n";
						$m .= '</div>' . "\n";
					}
					$m .= '</li>' . "\n";
				}
				$m .= '</ul>' ."\n";
				break;

			/* CORPORATE: SECONDARY MENU */
			case 'corporate-secondary-menu':
				$m .= '<ul id="' . $menu_id . '" class="' . $menu_classes . '">' . "\n";
				foreach ((array) $menu_items as $key => $menu_item) {
					$title      = $menu_item->title;
					$url        = $menu_item->url;
					$target     = $menu_item->target;
					$targetAttr = '';
					$classes    = $menu_item->classes;
					$cssClasses = '';

					if ($target != '') {
						$targetAttr = ' target="' . $target . '"';
					}
					if ($classes[0] != '') {
						$sep = '';

						foreach ($classes as &$value) {
							$cssClasses .= $sep . $value;
							$sep = ' ';
						}
					}

					$m .= '<li>' . "\n";
					$m .= '<a href="' . $url . '"' . $targetAttr . '>' . "\n";
					if ($cssClasses != '') {
						$m .= '<span class="' . $cssClasses . '"></span>' . "\n";
					}
					$m .= $title . "\n";
					$m .= '</a>' . "\n";
					$m .= '</li>' . "\n";
				}
				$m .= '</ul>' ."\n";
				break;

			/* CORPORATE: MAIN MENU IN FOOTER (WITH DESCRIPTIONS) */
			case 'corporate-main-menu-footer':
				$m .= '<ul id="' . $menu_id . '" class="' . $menu_classes . '">' . "\n";
				foreach ((array) $menu_items as $key => $menu_item) {
					$title       = $menu_item->title;
					$url         = $menu_item->url;
					$description = $menu_item->description;
					$target      = $menu_item->target;
					$targetAttr  = '';

					if ($target != '') {
						$targetAttr = ' target="' . $target . '"';
					}

					$m .= '<li>' . "\n";
					$m .= '<a href="' . $url . '"' . $targetAttr . '>' . "\n";
					$m .= '<span class="title">' . $title . '</span>' . "\n";
					$m .= '<span>' . $description . '</span>' . "\n";
					$m .= '</a>' . "\n";
					$m .= '</li>' . "\n";
				}
				$m .= '</ul>' ."\n";
				break;
		}
		echo $m;
	}
}
?>
