<?php
/**
 * @package SOCCERSHOTS
 */

$page_feature_image = get_field('page_feature_image');
$intro_copy         = get_field('intro_copy');
$imagesrc           = wp_get_attachment_image_src($page_feature_image,'franchise-page-feature');
/*
GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
*/

$class = '';
if (is_page('enroll') || is_page('find-your-region')) {
	$class = ' full-col';
}
?>
<div id="page-hero-wrapper">
	<div id="page-hero" style="background-image: url('<?php echo $imagesrc[0]; ?>')"></div>
	<div id="page-hero-copy">
		<div class="container<?php echo $class; ?>">
			<h1><?php echo get_the_title(); ?></span></h1>
			<?php if ($intro_copy != ''): ?>
			<p><?php echo $intro_copy; ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
