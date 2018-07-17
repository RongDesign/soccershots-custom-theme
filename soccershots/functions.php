<?php
function soccershots_setup_theme() {
	require 'lib/inc/init.php';
	require 'lib/inc/menus.php';
	require 'lib/inc/post-types.php';
	require 'lib/inc/shortcodes.php';
	require 'lib/inc/image-sizes.php';
	require 'lib/inc/admin.php';
}
add_action('after_setup_theme', 'soccershots_setup_theme');
