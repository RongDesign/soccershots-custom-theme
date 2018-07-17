<?php
/**
 * @package SOCCERSHOTS
 */

$topMostFranchisePageId       = get_post_top_ancestor_id();
$topMostFranchisePageSlug     = get_post($topMostFranchisePageId)->post_name;
$settingsID                   = get_franchise_settings_id($topMostFranchisePageSlug);
?>
<?php if (have_rows('coaches', $settingsID)): ?>
	<div class="module cf">
		<?php while(have_rows('coaches', $settingsID)): the_row(); ?>
			<?php
			$name        = get_sub_field('name');
			$title       = get_sub_field('title');
			$image       = get_sub_field('image');
			$imagesrc    = wp_get_attachment_image_src($image,'franchise-coach');
			/*
			GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
			GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
			*/

			$description = get_sub_field('description');
			$active      = get_sub_field('active');
			$imageClass  = '';
			?>
			<div class="coach cf">
				<?php if ($image): ?>
					<?php
						$imageClass = ' has-image';
					?>
					<div class="photo-wrapper">
						<p><img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $name; ?>"></p>
					</div>
				<?php endif; ?>
				<div class="coach-content<?php echo $imageClass; ?>">

					<h2><?php echo $name; ?></h2>
					<?php if($title): ?>
					<h3><?php echo $title; ?></h3>
					<?php endif; ?>
					<p><?php echo $description; ?></p>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
