<?php
/**
 * @package SOCCERSHOTS
 */

$partners = get_field('partners');
?>
<?php if ($partners): ?>
<h3 class="partners">Partners</h3>
<div id="partners-wrapper">
	<div id="partners-list" class="owl-carousel clist cf">
		<?php
		foreach($partners as $partner) :
			$id       = $partner['partner']->ID;
			$title    = get_the_title($id);
			$link     = get_field( "link", $id);
			$image    = get_field( "image", $id);
			/*
			GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
			GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
			*/
			$imagesrc = wp_get_attachment_image_src($image,'partner-logo');

			$target   = (get_field( "call_to_action_target", $id) == 1) ? ' target="_blank"' : '';

		?>
		<div class="partner">
			<?php if ($link != ''): ?>
			<a href="<?php echo $link; ?>"<?php echo $target; ?>>
				<p class="logo"><img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>">
				<p class="title"><?php echo $title; ?></p>
			</a>
			<?php else: ?>
			<p class="logo"><img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>"></p>
			<p class="title"><?php echo $title; ?></p>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>
