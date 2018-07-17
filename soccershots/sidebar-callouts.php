<?php
/**
* @package SOCCERSHOTS
*/

$topMostFranchisePageId   = get_post_top_ancestor_id();
$topMostFranchisePageSlug = get_post($topMostFranchisePageId)->post_name;
$franchise_root_path      = get_permalink($topMostFranchisePageId);
$callouts                 = get_field('callout');
?>

<?php if ($callouts): ?>
	<?php foreach($callouts as $callout) : ?>
		<?php
			$id            = $callout['callout_option']->ID;
			$title         = get_the_title($id);
			$callout_type  = get_field('callout_type', $id);
		?>
		<?php if (have_rows('callout_type', $id)): ?>
			<?php while ( have_rows('callout_type', $id) ) : the_row(); ?>
				<?php if (get_row_layout() == 'image_callout'): ?>
				<?php
					$image                 = get_sub_field('image');
					$imagesrc              = wp_get_attachment_image_src($image,'callout');
					/*
					GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
					GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
					*/
					$text                  = get_sub_field('text');
					$call_to_action        = get_sub_field('call_to_action');
					$call_to_action_text   = get_sub_field('call_to_action_text');
					$call_to_action_link   = get_sub_field('call_to_action_link');
					$call_to_action_target = get_sub_field('call_to_action_target');
					$target                = (get_sub_field( "call_to_action_target") == 1) ? ' target="_blank"' : '';
				?>
					<div class="callout callout-video">
						<h4><?php echo $title; ?></h4>
						<?php if ($imagesrc != ''): ?>
						<p class="callout-image">
							<?php if ($call_to_action): ?>
							<a href="<?php echo $call_to_action_link; ?>"<?php echo $target; ?>>
							<?php endif; ?>
								<img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>">
							<?php if ($call_to_action): ?>
							</a>
							<?php endif; ?>
						</p>
						<?php endif; ?>
						<p><?php echo $text; ?></p>

						<?php if ($call_to_action): ?>
						<p class="cta cta-dark">
							<a href="<?php echo $call_to_action_link; ?>"<?php echo $target; ?>>
								<span><?php echo $call_to_action_text; ?></span>
							</a>
						</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if (get_row_layout() == 'video_callout'): ?>
				<?php
					$video_url             = get_sub_field('video_url');
					$image                 = get_sub_field('image');
					$imagesrc              = wp_get_attachment_image_src($image,'callout');
					/*
					GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
					GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
					*/
					$text                  = get_sub_field('text');
					$call_to_action        = get_sub_field('call_to_action');
					$call_to_action_text   = get_sub_field('call_to_action_text');
					$call_to_action_link   = get_sub_field('call_to_action_link');
					$call_to_action_target = get_sub_field('call_to_action_target');
				?>
					<div class="callout callout-video">
						<h4><?php echo $title; ?></h4>
						<?php if ($imagesrc != ''): ?>
						<p class="callout-image">
							<a href="//www.youtube.com/watch?v=<?php echo $video_url; ?>" class="ga-exclude" data-behavior="modalize" data-title="<?php echo $title; ?>">
								<img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>">
								<span class="icon icon-play"></span>
							</a>
						</p>
						<?php endif; ?>
						<p><?php echo $text; ?></p>
					</div>
				<?php endif; ?>

				<?php if (get_row_layout() == 'enroll_at_a_site'): ?>
				<?php
					$video_url             = get_sub_field('video_url');
					$image                 = get_sub_field('image');
					$text                  = get_sub_field('text');
					$call_to_action        = get_sub_field('call_to_action');
					$call_to_action_text   = get_sub_field('call_to_action_text');
					$call_to_action_link   = get_sub_field('call_to_action_link');
					$call_to_action_target = get_sub_field('call_to_action_target');
				?>
					<div class="callout enroll-callout">
						<a href="https://<?php echo $topMostFranchisePageSlug; ?>.ssreg.org" target="_blank">
							<div class="txt-wrapper">
								<p class="txt">
									<span class="icon icon-location2"></span>
									<span class="line1">Enroll</span>
									<span class="line2">
										at a Site
										<span class="icon icon-arrow-circle-right"></span>
									</span>
								</p>
							</div>
						</a>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
