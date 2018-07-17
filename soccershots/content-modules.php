<?php
/**
* @package SOCCERSHOTS
*/

$topMostFranchisePageId       = get_post_top_ancestor_id();
$topMostFranchisePageSlug     = get_post($topMostFranchisePageId)->post_name;
$settingsID                   = get_franchise_settings_id($topMostFranchisePageSlug);
$franchise_root_path          = get_permalink(get_post_top_ancestor_id());
$modulesID                    = $post->ID;
$show_additional_page         = get_field('show_additional_page', $settingsID);
$sidebar_link_title           = '';
$sidebar_secondary_link_title = '';
$pagename                     = get_query_var('pagename');
?>

<?php /* add "Local Information" module if we're on the about page and the $local_information value is specfied */ ?>
<?php if ($pagename != '' && $pagename == 'about'): ?>
	<?php $local_information = get_field( "local_information", $settingsID); ?>
	<?php if ($local_information != ''): ?>
		<div class="module cf scrollto-local_information">
			<h2>Local Information</h2>
			<div class="module-copy">
				<?php echo $local_information; ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php if (have_rows('modules', $modulesID)): ?>
	<?php while ( have_rows('modules', $modulesID) ) : the_row(); ?>
		<?php if (get_row_layout() == 'content_area'): ?>
			<?php
			$title                 = get_sub_field('title');
			$display               = get_sub_field('display');
			$image                 = get_sub_field('image');
			/*
			GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
			GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
			*/
			$imagesrc              = wp_get_attachment_image_src($image,'module-image');

			$secondary_title       = get_sub_field('secondary_title');
			$text                  = get_sub_field('text');
			$add_call_to_action    = get_sub_field('add_call_to_action');
			$call_to_action_text   = get_sub_field('call_to_action_text');
			$call_to_action_link   = get_sub_field('call_to_action_link');
			$call_to_action_target = get_sub_field('call_to_action_target');
			$target                = (get_sub_field( "call_to_action_target") == 1) ? ' target="_blank"' : '';
			$slug                  = slugify_string($title);

			$slug_name = '';
			if ($display) {
				$slug_name = "scrollto-" . $slug;
			}
			$storyClass = '';
			if (is_page_template('page-templates/corporate-interior-stories.php') || is_page_template('page-templates/franchise-interior-stories.php')) {
				$storyClass = ' module-featured module-form ';
			}
			?>

			<div class="module cf <?php echo $storyClass . $slug_name; ?>">
				<?php if ($imagesrc != ''): ?>
				<p class="module-image"><img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>"></p>
				<?php endif; ?>

				<?php if ($title != ''): ?>
				<h2><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php if ($secondary_title != ''): ?>
				<h3><?php echo $secondary_title; ?></h3>
				<?php endif; ?>

				<div class="module-copy">
					<?php echo $text; ?>
				</div>

				<?php if ($add_call_to_action): ?>
				<p class="cta-dark">
					<a href="<?php echo $call_to_action_link; ?>"<?php echo $target; ?>>
						<span><?php echo $call_to_action_text; ?></span>
					</a>
				</p>
				<?php endif; ?>
			</div>
		<?php elseif (get_row_layout() == 'global_content_area'): ?>
			<?php
			$global_id = get_sub_field('global_content_item');

			if ($global_id):
				$title                 = get_field('title', $global_id);
				$display               = get_field('display', $global_id);
				$image                 = get_field('image', $global_id);
				/*
				GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
				GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
				*/
				$imagesrc              = wp_get_attachment_image_src($image,'module-image');

				$secondary_title       = get_field('secondary_title', $global_id);
				$text                  = get_field('text', $global_id);
				$add_call_to_action    = get_field('add_call_to_action', $global_id);
				$call_to_action_text   = get_field('call_to_action_text', $global_id);
				$call_to_action_link   = get_field('call_to_action_link', $global_id);
				$call_to_action_target = get_field('call_to_action_target', $global_id);
				$target                = (get_field( "call_to_action_target", $global_id) == 1) ? ' target="_blank"' : '';
				$slug                  = slugify_string($title);

				$slug_name = '';
				if ($display && $title != '') {
					$slug_name = "scrollto-" . $slug;
				}
				$storyClass = '';
				if (is_page_template('page-templates/corporate-interior-stories.php') || is_page_template('page-templates/franchise-interior-stories.php')) {
					$storyClass = ' module-featured module-form ';
				}
				?>

				<div class="module cf <?php echo $storyClass . $slug_name; ?>">
					<?php if ($imagesrc != ''): ?>
					<p class="module-image"><img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>"></p>
					<?php endif; ?>

					<?php if ($title != ''): ?>
					<h2><?php echo $title; ?></h2>
					<?php endif; ?>
					<?php if ($secondary_title != ''): ?>
					<h3><?php echo $secondary_title; ?></h3>
					<?php endif; ?>

					<div class="module-copy">
						<?php echo $text; ?>
					</div>

					<?php if ($add_call_to_action): ?>
					<p class="cta-dark">
						<a href="<?php echo $call_to_action_link; ?>"<?php echo $target; ?>>
							<span><?php echo $call_to_action_text; ?></span>
						</a>
					</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php elseif (get_row_layout() == 'expand_collapse_list'): ?>
			<?php if (have_rows('expandcollapse_list', $modulesID)): ?>
				<div class="module module-expand-collapse cf">
					<?php $i = 1; ?>
					<?php while(have_rows('expandcollapse_list', $modulesID)): the_row(); ?>
						<?php
						$title = get_sub_field('title');
						$details = get_sub_field('details');
						?>
							<div class="expand-collapse-item">
								<p class="ec-title">
									<a href="#faq<?php echo $i; ?>" title="Show Details">
										<span class="txt"><?php echo $title; ?></span>
										<span class="icon icon-caret-down"></span>
									</a>
								</p>
								<div class="ec-details">
									<?php echo $details; ?>
								</div>
							</div>
						<?php $i++; ?>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>

<?php
/* determine whether to display franchise additional content for franchise navigation (for camps/birthday parties/special events page) */
if (strpos($post->post_name, 'programs') !== false && $show_additional_page && is_page_template('page-templates/franchise-interior.php')):
?>
	<?php while ( have_rows('modules', $settingsID) ) : the_row(); ?>
		<?php if (get_row_layout() == 'content_area'): ?>
			<?php
			$title                 = get_sub_field('title');
			$display               = get_sub_field('display');
			$image                 = get_sub_field('image');
			/*
			GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
			GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
			*/
			$imagesrc              = wp_get_attachment_image_src($image,'module-image');

			$secondary_title       = get_sub_field('secondary_title');
			$text                  = get_sub_field('text');
			$add_call_to_action    = get_sub_field('add_call_to_action');
			$call_to_action_text   = get_sub_field('call_to_action_text');
			$call_to_action_link   = get_sub_field('call_to_action_link');
			$call_to_action_target = get_sub_field('call_to_action_target');
			$target                = (get_sub_field( "call_to_action_target") == 1) ? ' target="_blank"' : '';
			$slug                  = slugify_string($title);
			$slug_name = '';

			if ($display) {
				$slug_name = "scrollto-" . $slug;
			}
			?>

			<div class="module cf <?php echo $slug_name; ?>">
				<?php if ($imagesrc != ''): ?>
				<p class="module-image"><img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>"></p>
				<?php endif; ?>

				<?php if ($title != ''): ?>
				<h2><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php if ($secondary_title != ''): ?>
				<h3><?php echo $secondary_title; ?></h3>
				<?php endif; ?>

				<div class="module-copy">
					<?php echo $text; ?>
				</div>

				<?php if ($add_call_to_action): ?>
				<p class="cta-dark">
					<a href="<?php echo $call_to_action_link; ?>"<?php echo $target; ?>>
						<span><?php echo $call_to_action_text; ?></span>
					</a>
				</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>
