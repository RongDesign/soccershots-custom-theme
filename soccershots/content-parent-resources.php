<?php
/**
 * @package SOCCERSHOTS
 */

$parent_resources = get_field('parent_resources');
?>
<?php if ($parent_resources): ?>
	<?php
	foreach($parent_resources as $parent_resource) :
		$id                    = $parent_resource['parent_resource']->ID;
		$title                 = get_the_title($id);
		$display               = get_field('display', $id);
		$image                 = get_field('image', $id);
		/*
		GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
		GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
		*/
		$imagesrc              = wp_get_attachment_image_src($image,'module-image');

		$secondary_title       = get_field('secondary_title', $id);
		$text                  = get_field('text', $id);
		$add_call_to_action    = get_field('add_call_to_action', $id);
		$call_to_action_text   = get_field('call_to_action_text', $id);
		$call_to_action_link   = get_field('call_to_action_link', $id);
		$call_to_action_target = get_field('call_to_action_target', $id);
		$target                = (get_field( "call_to_action_target", $id) == 1) ? ' target="_blank"' : '';
		$slug                  = slugify_string($title);

		$slug_name = '';
		if ($display) {
			$slug_name = "scrollto-" . $slug;
		}
	?>
	<div class="module module-<?php echo $type; ?> cf <?php echo $slug_name; ?>">
		<?php if ($image['url'] != ''): ?>
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
	<?php $featured = ''; ?>
	<?php endforeach; ?>
<?php endif; ?>
