<?php
/* THEME INITIALIZATION */
function soccershots_init() {
	/* remove extraneous meta tags from <head> */
	remove_action('wp_head', 'feed_links_extra', 3);             // Removes the links to the extra feeds such as category feeds
	remove_action('wp_head', 'feed_links', 2);                   // Removes links to the general feeds: Post and Comment Feed
	remove_action('wp_head', 'rsd_link');                        // Removes the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action('wp_head', 'wlwmanifest_link');                // Removes the link to the Windows Live Writer manifest file.
	remove_action('wp_head', 'index_rel_link');                  // Removes the index link
	remove_action('wp_head', 'parent_post_rel_link');            // Removes the prev link
	remove_action('wp_head', 'start_post_rel_link');             // Removes the start link
	remove_action('wp_head', 'adjacent_posts_rel_link');         // Removes the relational links for the posts adjacent to the current post.
	remove_action('wp_head', 'wp_generator');                    // Removes the WordPress version i.e. - WordPress 2.8.4
	remove_action('wp_head', 'print_emoji_detection_script', 7); // Removes Emoji script, which was added in WordPress 4.2
	remove_action('wp_print_styles', 'print_emoji_styles');      // Removes Emoji css block, which was added in WordPress 4.2

	/*register menus*/
	register_nav_menu('corporate-main-menu', __( 'Corporate: Main Menu' ));
	register_nav_menu('corporate-secondary-menu', __( 'Corporate: Secondary Menu' ));
	register_nav_menu('corporate-copyright-menu', __( 'Corporate: Copyright Menu' ));
	register_nav_menu('franchise-copyright-menu', __( 'Franchise: Copyright Menu' ));
}
add_action('init', 'soccershots_init');

/* ENQUEUE SCRIPTS AND STYLESHEETS */
function soccershots_enqueue_scripts() {
	/* enqueue site stylesheet */
	wp_enqueue_style('carousel',     get_template_directory_uri() . '/lib/css/owl.carousel.min.css');
	wp_enqueue_style('scrollbar',    get_template_directory_uri() . '/lib/css/jquery.mCustomScrollbar.min.css');
	wp_enqueue_style('soccershots',  get_stylesheet_uri());

	/* remove default jquery */
	wp_deregister_script('jquery');

	/* enqueue site scripts */
	wp_enqueue_script('respond',     get_template_directory_uri() . '/lib/js/respond.min.js',                        array(), '', true);
	wp_enqueue_script('jquery',      get_template_directory_uri() . '/lib/js/jquery-1.11.3.min.js',                  array(), '', true);
	wp_enqueue_script('easing',      get_template_directory_uri() . '/lib/js/jquery.easing.1.3.min.js',              array(), '', true);
	wp_enqueue_script('list',        get_template_directory_uri() . '/lib/js/list.min.js',                           array(), '', true);
	wp_enqueue_script('touchswipe',  get_template_directory_uri() . '/lib/js/jquery.touchSwipe.min.js',              array(), '', true);
	wp_enqueue_script('simplemodal', get_template_directory_uri() . '/lib/js/jquery.simplemodal.js',                 array(), '', true);
	wp_enqueue_script('carousel',    get_template_directory_uri() . '/lib/js/owl.carousel.min.js',                   array(), '', true);
	wp_enqueue_script('scrollbar',   get_template_directory_uri() . '/lib/js/jquery.mCustomScrollbar.concat.min.js', array(), '', true);
	wp_enqueue_script('script',      get_template_directory_uri() . '/lib/js/script.js',                             array(), '', true);
}
add_action('wp_enqueue_scripts', 'soccershots_enqueue_scripts');

/* GET POST TOP ANCESTOR ID */
if (!function_exists('get_post_top_ancestor_id')) {
	/**
	 * Gets the id of the topmost ancestor of the current page. Returns the current
	 * page's id if there is no parent.
	 *
	 * @uses object $post
	 * @return int
	 */
	function get_post_top_ancestor_id() {
		global $post;

		/* Get an array of Ancestors and Parents if they exist */
		$parents = get_post_ancestors($post->ID);

		/* Get the top Level page->ID count base 1, array base 0 so -1 */
		$id = ($parents) ? $parents[count($parents)-1]: $post->ID;

		return $id;
	}
}

/* GET POST TOP ANCESTOR SLUG (TO USE AS BODY CLASS) */
if (!function_exists('get_post_top_ancestor_slug')) {
	function get_post_top_ancestor_slug() {
		$postname = '';

		if(is_page()) {
			$id = get_post_top_ancestor_id();

			/* Get the parent and set the $class with the page slug (post_name) */
			$parent = get_post( $id );

			$postname = $parent->post_name;
		}
		return $postname;
	}
}

/* GET ID FROM 'franchises' POST TYPE (USED TO PULL IN SEPERATE CONTENT FROM THE FRANCHISE SETTINGS PAGE) */
if (!function_exists('get_franchise_settings_id')) {
	function get_franchise_settings_id($slug = '') {
		$args = array(
			'posts_per_page'   => 1,
			'name'             => $slug,
			'post_type'        => 'franchises',
			'post_status'      => 'publish'
		);
		$posts_array = get_posts($args);
		return $posts_array[0]->ID;
	}
}

/* SLUGIFY STRING */
if (!function_exists('slugify_string')) {
	function slugify_string($slug = '') {
		$slug = str_replace('"', '', $slug); // REPLACE DOUBLE QUOTE "
		$slug = str_replace("“", '', $slug); // REPLACE LEFT CURLY DOUBLE QUOTE “
		$slug = str_replace("”", '', $slug); // REPLACE RIGHT CURLY DOUBLE QUOTE ”
		$slug = str_replace("'", '', $slug); // REPLACE SINGLE QUOTE '
		$slug = str_replace("‘", '', $slug); // REPLACE LEFT CURLY SINGLE QUOTE ‘
		$slug = str_replace("’", '', $slug); // REPLACE RIGHT CURLY SINGLE QUOTE ’
		$slug = str_replace("–", '', $slug); // REPLACE HYPHEN –
		$slug = sanitize_title_with_dashes($slug);

		return $slug;
	}
}
?>
