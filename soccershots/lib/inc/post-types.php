<?php
/* register the "franchises" post type */
function soccershots_register_post_type_franchise() {
	$labels = array(
		'name'               => 'Franchises',
		'singular_name'      => 'Franchise',
		'add_new'            => 'Add Franchise',
		'add_new_item'       => 'Add Franchise',
		'edit_item'          => 'Edit Franchise',
		'new_item'           => 'New Franchise',
		'all_items'          => 'All Franchises',
		'view_item'          => 'View Franchises',
		'search_items'       => 'Search Franchises',
		'not_found'          => 'No Franchises found',
		'not_found_in_trash' => 'No Franchises found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Franchises'
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'Soccer Shots Franchise Settings.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-location',
		'menu_position'      => 15,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'franchises')
	);
	register_post_type('franchises', $args);
}

/* register the "homeslides" post type */
function soccershots_register_post_type_homeslides() {
	$labels = array(
		'name'               => 'Home Slides',
		'singular_name'      => 'Slide',
		'add_new'            => 'Add Slide',
		'add_new_item'       => 'Add Slide',
		'edit_item'          => 'Edit Slide',
		'new_item'           => 'New Slide',
		'all_items'          => 'All Slides',
		'view_item'          => 'View Slides',
		'search_items'       => 'Search Slides',
		'not_found'          => 'No Home Slides found',
		'not_found_in_trash' => 'No Home Slides found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Home Slides'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Contains all of the home page slideshow options.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-images-alt',
		'menu_position'      => 20,
		'supports'           => array('title'),
		'hierarchical'       => true,
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'homeslides')
	);
	register_post_type('homeslides', $args);
}

/* register the "homehighlights" post type */
function soccershots_register_post_type_homehighlights() {
	$labels = array(
		'name'               => 'Home Highlights',
		'singular_name'      => 'Highlight',
		'add_new'            => 'Add Highlight',
		'add_new_item'       => 'Add Highlight',
		'edit_item'          => 'Edit Highlight',
		'new_item'           => 'New Highlight',
		'all_items'          => 'All Highlights',
		'view_item'          => 'View Highlights',
		'search_items'       => 'Search Highlights',
		'not_found'          => 'No Home Highlights found',
		'not_found_in_trash' => 'No Home Highlights found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Home Highlights'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Contains the three home page highlight areas (Coaching, Curriculum, Communication.)',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-id-alt',
		'menu_position'      => 21,
		'supports'           => array('title'),
		'hierarchical'       => true,
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'homehighlights')
	);
	register_post_type('homehighlights', $args);
}

/* register the "homehighlights" post type */
function soccershots_register_post_type_homevideos() {
	$labels = array(
		'name'               => 'Home Videos',
		'singular_name'      => 'Video',
		'add_new'            => 'Add Video',
		'add_new_item'       => 'Add Video',
		'edit_item'          => 'Edit Video',
		'new_item'           => 'New Video',
		'all_items'          => 'All Videos',
		'view_item'          => 'View Videos',
		'search_items'       => 'Search Videos',
		'not_found'          => 'No Home Videos found',
		'not_found_in_trash' => 'No Home Videos found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Home Videos'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Contains the franchise home page video areas.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-video-alt3',
		'menu_position'      => 22,
		'supports'           => array('title'),
		'hierarchical'       => true,
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'homevideos')
	);
	register_post_type('homevideos', $args);
}

/* register the "partners" post type */
function soccershots_register_post_type_partners() {
	$labels = array(
		'name'               => 'Partners',
		'singular_name'      => 'Partner',
		'add_new'            => 'Add Partner',
		'add_new_item'       => 'Add Partner',
		'edit_item'          => 'Edit Partner',
		'new_item'           => 'New Partner',
		'all_items'          => 'All Partners',
		'view_item'          => 'View Partners',
		'search_items'       => 'Search Partners',
		'not_found'          => 'No Partners found',
		'not_found_in_trash' => 'No Partners found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Partners'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Listing of Soccer Shots Partners.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-groups',
		'menu_position'      => 40,
		'supports'           => array('title'),
		'hierarchical'       => true,
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'partners')
	);
	register_post_type('partners', $args);
}

/* register the "stories" post type */
function soccershots_register_post_type_stories() {
	$labels = array(
		'name'               => 'Stories',
		'singular_name'      => 'Story',
		'add_new'            => 'Add Story',
		'add_new_item'       => 'Add Story',
		'edit_item'          => 'Edit Story',
		'new_item'           => 'New Story',
		'all_items'          => 'All Stories',
		'view_item'          => 'View Stories',
		'search_items'       => 'Search Stories',
		'not_found'          => 'No Stories found',
		'not_found_in_trash' => 'No Stories found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Stories'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Soccer Shots Stories.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-book-alt',
		'menu_position'      => 41,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'stories')
	);
	register_post_type('stories', $args);
}

/* register the "parent resources" post type */
function soccershots_register_post_type_parentresources() {
	$labels = array(
		'name'               => 'Parent Resources',
		'singular_name'      => 'Parent Resource',
		'add_new'            => 'Add Parent Resource',
		'add_new_item'       => 'Add Parent Resource',
		'edit_item'          => 'Edit Parent Resource',
		'new_item'           => 'New Parent Resource',
		'all_items'          => 'All Parent Resources',
		'view_item'          => 'View Parent Resources',
		'search_items'       => 'Search Parent Resources',
		'not_found'          => 'No Parent Resources found',
		'not_found_in_trash' => 'No Parent Resources found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Parent Resources'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Soccer Shots Parent Resources.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-cloud',
		'menu_position'      => 42,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'parentresources')
	);
	register_post_type('parentresources', $args);
}

/* register the "callouts" post type */
function soccershots_register_post_type_callouts() {
	$labels = array(
		'name'               => 'Callouts',
		'singular_name'      => 'Callout',
		'add_new'            => 'Add Callout',
		'add_new_item'       => 'Add Callout',
		'edit_item'          => 'Edit Callout',
		'new_item'           => 'New Callout',
		'all_items'          => 'All Callouts',
		'view_item'          => 'View Callouts',
		'search_items'       => 'Search Callouts',
		'not_found'          => 'No Callouts found',
		'not_found_in_trash' => 'No Callouts found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Callouts'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Soccer Shots Page Callouts.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-tablet',
		'menu_position'      => 43,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'callouts')
	);
	register_post_type('callouts', $args);
}

/* register the "global content" post type */
function soccershots_register_post_type_global_content() {
	$labels = array(
		'name'               => 'Global Content',
		'singular_name'      => 'Global Content',
		'add_new'            => 'Add Global Content',
		'add_new_item'       => 'Add Global Content',
		'edit_item'          => 'Edit Global Content',
		'new_item'           => 'New Global Content',
		'all_items'          => 'All Global Content',
		'view_item'          => 'View Global Content',
		'search_items'       => 'Search Global Content',
		'not_found'          => 'No Global Content found',
		'not_found_in_trash' => 'No Global Content found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Global Content'
	);
	/* restrict access to custom post (admins only) */
	$capabilities = array(
		'edit_post'          => 'update_core',
		'read_post'          => 'update_core',
		'delete_post'        => 'update_core',
		'edit_posts'         => 'update_core',
		'edit_others_posts'  => 'update_core',
		'delete_posts'       => 'update_core',
		'publish_posts'      => 'update_core',
		'read_private_posts' => 'update_core'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'Soccer Shots Global Blocks of Content.',
		'public'             => true,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-admin-site',
		'menu_position'      => 44,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'globalcontent')
	);
	register_post_type('globalcontent', $args);
}

function soccershots_register_post_types() {
	soccershots_register_post_type_homeslides();
	soccershots_register_post_type_homehighlights();
	soccershots_register_post_type_homevideos();
	soccershots_register_post_type_partners();
	soccershots_register_post_type_franchise();
	soccershots_register_post_type_stories();
	soccershots_register_post_type_parentresources();
	soccershots_register_post_type_callouts();
	soccershots_register_post_type_global_content();
}
add_action('init', 'soccershots_register_post_types');
?>
