<?php
	add_image_size('homepage-slide',         1400,  763, true);
	add_image_size('franchise-page-feature', 1400,  575, true);
	add_image_size('module-image',            804, 9999, false);
	add_image_size('franchise-home-video',    735,  413, true);
	add_image_size('callout',                 600, 9999, false); // double width of sidebar (300)
	add_image_size('partner-logo',            364,  288, true);
	add_image_size('homepage-highlight',      360,  548, true);
	add_image_size('franchise-coach',         200,  250, true);

	add_filter( 'image_size_names_choose', 'my_custom_sizes' );

	function my_custom_sizes($sizes) {
		return array_merge( $sizes, array(
			'homepage-slide'         => __('Homepage Slide'),
			'franchise-page-feature' => __('Page Hero Image'),
			'module-image'           => __('Module Image'),
			'franchise-home-video'   => __('Franchise Home Video Poster'),
			'callout'                => __('Sidebar Callout'),
			'partner-logo'           => __('Partner Logo'),
			'homepage-highlight'     => __('Homepage Highlight'),
			'franchise-coach'        => __('Franchise Coach')
		) );
	}
?>
