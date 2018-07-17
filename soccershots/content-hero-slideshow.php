<?php
/**
 * @package SOCCERSHOTS
 */

$slides = get_field('slides');
if (is_page_template('page-templates/franchise-home.php') || is_page_template('page-templates/franchise-interior.php')) {
	$topMostFranchisePageId   = get_post_top_ancestor_id();
	$topMostFranchisePageSlug = get_post($topMostFranchisePageId)->post_name;
	$settingsID               = get_franchise_settings_id($topMostFranchisePageSlug);
	$slides                   = get_field('slides', $settingsID);
}
$first_slide_image = get_field('image', $slides[0]['slide']->ID);
$first_slide_image_src = wp_get_attachment_image_src($first_slide_image,'homepage-slide');
?>
<div id="slideshow-wrapper">
	<?php if ($slides): ?>
	<div id="slideshow" style="background-image: url('<?php echo $first_slide_image_src[0]; ?>');">
		<?php if (count($slides ) > 1): ?>
		<div id="slide-transition"></div>
		<div id="slide-loader"></div>
		<?php endif; ?>
	</div>

	<div id="slideshow-content">
		<div class="container">
			<?php
			$i = 1;
			foreach($slides as $slide) :
				$id            = $slide['slide']->ID;
				$title         = get_the_title($id);
				$text          = get_field( "text", $id);
				$text_location = get_field( "text_location", $id);
				$button_text   = get_field( "button_text", $id);
				$button_link   = get_field( "button_link", $id);
				$target        = (get_field( "target", $id) == 1) ? ' target="_blank"' : '';
				$modal         = get_field( "modal", $id);
				$image         = get_field( "image", $id);
				/*
				GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
				GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
				*/
				$imagesrc      = wp_get_attachment_image_src($image,'homepage-slide');

				$display       = ($i == 1) ? '' : ' style="display: none;"';
			?>
			<div class="slide-container <?php echo $text_location; ?> slide-container<?php echo $i; ?>"<?php echo $display; ?>>
				<div class="slide" data-bg="<?php echo $imagesrc[0]; ?>">
					<h1><?php echo $title; ?></h1>
					<p class="slide-copy"><?php echo $text; ?></p>
					<p class="cta">
						<?php if ($modal): ?>
						<a href="<?php echo $button_link; ?>" class="ga-exclude" data-title="<?php echo $title; ?>" data-behavior="modalize">
						<?php else: ?>
						<a href="<?php echo $button_link; ?>"<?php echo $target; ?>>
						<?php endif; ?>
							<span><?php echo $button_text; ?></span>
						</a>
					</p>

					<ul class="slide-nav clist cf">
					<?php
						$j = 1;
						while ($j <= count($slides)) :
							$active = ($i == $j) ? ' class="active"' : '';
					?>
						<li>
							<a href="#slide<?php echo $j; ?>"<?php echo $active; ?>>
								<span><?php echo $j; ?></span>
							</a>
						</li>
					<?php
							$j++;
						endwhile;
					?>
					</ul>
				</div>
			</div>
			<?php
				$i++;
			endforeach;
			?>
		</div>
	</div>

	<div id="slideshow-controls">
		<?php if (count($slides ) > 1): ?>
		<a href="#previous" class="slideshow-prev icon-angle-left" rel="nofollow">
			<span>Previous</span>
		</a>

		<a href="#next" class="slideshow-next icon-angle-right" rel="nofollow">
			<span>Next</span>
		</a>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
