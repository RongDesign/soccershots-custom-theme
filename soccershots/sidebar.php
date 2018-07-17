<?php
/**
* @package SOCCERSHOTS
*/

$topMostFranchisePageId   = get_post_top_ancestor_id();
$topMostFranchisePageSlug = get_post($topMostFranchisePageId)->post_name;
$settingsID               = get_franchise_settings_id($topMostFranchisePageSlug);
$franchise_root_path      = get_permalink($topMostFranchisePageId);
$modulesID                = $post->ID;
$show_additional_page     = get_field('show_additional_page', $settingsID);
$stories                  = get_field('stories');
$pagename                 = get_query_var('pagename');
$nav                      = '';

if (is_page_template('page-templates/corporate-interior-stories.php') || is_page_template('page-templates/franchise-interior-stories.php')) {
	/* stories sidebar */
	foreach($stories as $story) {
		$id              = $story['story']->ID;
		$title           = get_the_title($id);
		$display         = get_field('display', $id);
		$secondary_title = get_field('secondary_title', $id);
		$slug            = slugify_string($title);

		if ($display) {
			$nav .= '<li>';
			$nav .= '<a href="#' . $slug . '">';
			$nav .= $title;
			if ($secondary_title != ''):
				$nav .= '<span class="secondary">' . $secondary_title . '</span>';
			endif;
			$nav .= '<span class="icon icon-angle-right"></span>';
			$nav .= '</a>';
			$nav .= '</li>';
		}
	}
}

/* build "Local Information" sidebar nav if we're on the about page and the $local_information value is specfied */
if ($pagename != '' && $pagename == 'about') {
	$local_information = get_field( "local_information", $settingsID);

	if ($local_information != '') {
		$nav .= '<li>';
		$nav .= '<a href="#local_information">';
		$nav .= 'Local Information';
		$nav .= '<span class="icon icon-angle-right"></span>';
		$nav .= '</a>';
		$nav .= '</li>';
	}
}

/* standard sidebar (not stories) */
while ( have_rows('modules', $modulesID) ) : the_row();
	if (get_row_layout() == 'content_area'):
		$display         = get_sub_field('display');
		$title           = get_sub_field('title');
		$secondary_title = get_sub_field('secondary_title');
		$slug            = slugify_string($title);

		if ($display):
			$nav .= '<li>';
			$nav .= '<a href="#' . $slug . '">';
			$nav .= $title;
			if ($secondary_title != ''):
				$nav .= '<span class="secondary">' . $secondary_title . '</span>';
			endif;
			$nav .= '<span class="icon icon-angle-right"></span>';
			$nav .= '</a>';
			$nav .= '</li>';
		endif;
	elseif (get_row_layout() == 'global_content_area'):
		$global_id = get_sub_field('global_content_item');

		if ($global_id):
			$display         = get_field('display', $global_id);
			$title           = get_field('title', $global_id);
			$secondary_title = get_field('secondary_title', $global_id);
			$slug            = slugify_string($title);

			if ($display && $title != ''):
				$nav .= '<li>';
				$nav .= '<a href="#' . $slug . '">';
				$nav .= $title;
				if ($secondary_title != ''):
					$nav .= '<span class="secondary">' . $secondary_title . '</span>';
				endif;
				$nav .= '<span class="icon icon-angle-right"></span>';
				$nav .= '</a>';
				$nav .= '</li>';
			endif;
		endif;
	endif;
endwhile;

/* determine whether to display franchise additional content for franchise navigation (for camps/birthday parties/special events page) */
if (strpos($post->post_name, 'programs') !== false && $show_additional_page && is_page_template('page-templates/franchise-interior.php')):
	while ( have_rows('modules', $settingsID) ) : the_row();
		if (get_row_layout() == 'content_area'):
			$display         = get_sub_field('display');
			$title           = get_sub_field('title');
			$secondary_title = get_sub_field('secondary_title');
			$slug            = slugify_string($title);

			if ($display):
				$nav .= '<li>';
				$nav .= '<a href="#' . $slug . '">';
				$nav .= $title;
				if ($secondary_title != ''):
					$nav .= '<span class="secondary">' . $secondary_title . '</span>';
				endif;
				$nav .= '<span class="icon icon-angle-right"></span>';
				$nav .= '</a>';
				$nav .= '</li>';
			endif;
		endif;
	endwhile;
endif;
?>

<aside id="sidebar">
	<?php if ($nav != ''): ?>
		<div id="sub-nav-wrapper">
			<a href="#jump-to-menu" id="sub-nav-menu" rel="nofollow">
				Jump To
				<span class="icon icon-caret-down"></span>
			</a>
			<ul id="sub-nav" class="clist">
				<?php echo $nav; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php get_template_part('sidebar', 'callouts'); ?>
</aside>
