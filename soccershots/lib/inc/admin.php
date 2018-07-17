<?php
function soccershots_admin_menu_page() {
	require 'admin/soccershots-settings.php';
}

/* ADD/REMOVE ADMIN MENU ITEMS */
function soccershots_admin_menu() {
	/* add soccer shots settings menu item (as a submenu item under "Settings") */
	add_submenu_page('options-general.php', 'Soccer Shots Website Settings', 'Soccer Shots Website Settings', 'manage_options', 'soccershots-settings', 'soccershots_admin_menu_page');

	/* remove menu items */
	/*
		remove_menu_page('index.php');               //Dashboard
		remove_menu_page('edit.php');                //Posts
		remove_menu_page('upload.php');              //Media
		remove_menu_page('edit.php?post_type=page'); //Pages
		remove_menu_page('edit-comments.php');       //Comments
		remove_menu_page('themes.php');              //Appearance
		remove_menu_page('plugins.php');             //Plugins
		remove_menu_page('users.php');               //Users
		remove_menu_page('tools.php');               //Tools
		remove_menu_page('options-general.php');     //Settings
	*/

	if (!current_user_can('manage_options')) {
		// HIDE DASHBOARD FROM FRANCHISE USERS
		remove_menu_page('index.php');               //Dashboard
		remove_menu_page('edit.php');                //Posts
		remove_menu_page('edit-comments.php');       //Comments
		remove_menu_page('tools.php');               //Tools

		// REMOVE DASHBOARD META BOXES
		remove_meta_box('dashboard_incoming_links',  'dashboard', 'normal');
		remove_meta_box('dashboard_plugins',         'dashboard', 'normal');
		remove_meta_box('dashboard_primary',         'dashboard', 'side');
		remove_meta_box('dashboard_secondary',       'dashboard', 'normal');
		remove_meta_box('dashboard_quick_press',     'dashboard', 'side');
		remove_meta_box('dashboard_recent_drafts',   'dashboard', 'side');
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		remove_meta_box('dashboard_right_now',       'dashboard', 'normal');
		remove_meta_box('dashboard_activity',        'dashboard', 'normal');
	}
}
add_action('admin_menu', 'soccershots_admin_menu');

function soccershots_admin_settings() {
	register_setting('jpl-settings-group', 'soccershots_facebook_url');
	register_setting('jpl-settings-group', 'soccershots_twitter_url');
	register_setting('jpl-settings-group', 'soccershots_linkedin_url');
	register_setting('jpl-settings-group', 'soccershots_youtube_url');
	register_setting('jpl-settings-group', 'soccershots_footer_copyright');
	register_setting('jpl-settings-group', 'soccershots_home_highlight1');
	register_setting('jpl-settings-group', 'soccershots_home_highlight2');
	register_setting('jpl-settings-group', 'soccershots_home_highlight3');
	register_setting('jpl-settings-group', 'soccershots_home_video');
	register_setting('jpl-settings-group', 'soccershots_google_maps_key');
	register_setting('jpl-settings-group', 'soccershots_google_analytics_account_id');
	register_setting('jpl-settings-group', 'soccershots_typekit_account_id');
}
add_action('admin_init', 'soccershots_admin_settings');

/* REMOVE WORDPRESS SEO (YOAST) PAGES FROM NON-ADMINISTRATORS */
function soccershots_hide_yoastseo() {
	if (!current_user_can('administrator')) :
		remove_action('admin_bar_menu', 'wpseo_admin_bar_menu',95);
		remove_menu_page('wpseo_dashboard');
	endif;
}
add_action('admin_init', 'soccershots_hide_yoastseo');

/* REDIRECT FRANCHISE USERS TO FRANCHISES PAGE (NOT THE DEFAULT PAGE, WHICH IS THE DASHBOARD) */
add_filter('login_redirect', 'dashboard_redirect');
function dashboard_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	global $user;
	if (isset($user->roles) && is_array($user->roles)) {
		//check for admins
		if (in_array('administrator', $user->roles)) {
			// redirect them to the default place
			return $redirect_to;
		} else {
			return esc_url(admin_url('edit.php?post_type=franchises'));
		}
	} else {
		return $redirect_to;
	}
}

/* ENQUEUE ADMIN CSS */
function soccershots_admin_login_css() {
?>
	<style type="text/css">
		body.login {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/lib/img/admin/bg.jpg);
			background-position: top center;
			background-repeat: no-repeat;
			background-size: cover;
		}
		body.login h1 {
			background: #fff;
		}
		body.login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/lib/img/admin/logo.png);
			background-size: auto;
			background-position: center 5px;
			margin-bottom: 0px;
			padding-bottom: 0px;
			width: 100%;
		}
		body.login form {
			box-shadow: none;
			margin-top: 0px;
			padding-bottom: 26px;
		}
		body.login #nav, body.login #backtoblog {
			background: #fff;
			margin-top: 0px;
			padding-bottom: 10px;
		}
		a {
			color: #f79022;
		}
		a:active, a:hover {
			color: #da7a13;
		}
		.login #backtoblog a:hover, .login #nav a:hover {
			color: #da7a13;
		}
		.login .message {
			border-color: #f79022;
		}
		.wp-core-ui .button-primary {
			background: #f79022;
			border-color: #da7a13;
		}
		.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover,
		.wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {
			background: #da7a13;
			border-color: #b9660d;
		}
		.wp-core-ui .button-primary.active, .wp-core-ui .button-primary.active:focus,
		.wp-core-ui .button-primary.active:hover, .wp-core-ui .button-primary:active {
			background: #a0590d;
			border-color: #90500c;
		}
	</style>
<?php
}
add_action('login_enqueue_scripts', 'soccershots_admin_login_css');

function soccershots_admin_headerurl() {
	return home_url();
}
add_filter('login_headerurl', 'soccershots_admin_headerurl');
?>
