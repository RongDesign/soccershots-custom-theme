<?php
/**
 * Template Name: Corporate: Home
 */

get_header();

$home_highlight1   = get_option('soccershots_home_highlight1');
$home_highlight2   = get_option('soccershots_home_highlight2');
$home_highlight3   = get_option('soccershots_home_highlight3');
$highlights        = array($home_highlight2, $home_highlight1, $home_highlight3);
$title1            = get_field('title1');
?>
<?php get_template_part('header', 'corporate'); ?>

<section id="section-home">
	<?php get_template_part('content', 'hero-slideshow'); ?>

	<div class="container">
		<h2><?php echo $title1; ?></h2>
		<?php the_content(); ?>

		<?php if ($highlights): ?>
		<ul id="highlights" class="clist cf">
			<?php
			foreach($highlights as $highlight) :
				$id            = $highlight;
				$title         = get_the_title($id);
				$icon          = get_field( "icon", $id);
				$text          = get_field( "text", $id);
				$text_location = get_field( "text_location", $id);
				$button_text   = get_field( "button_text", $id);
				$button_link   = get_field( "button_link", $id);
				$target        = (get_field( "target", $id) == 1) ? ' target="_blank"' : '';
				$image         = get_field( "image", $id);
				/*
				GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
				GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
				*/
				$imagesrc      = wp_get_attachment_image_src($image,'homepage-highlight');
			?>
			<li style="background-image: url('<?php echo $imagesrc[0]; ?>');">
				<div class="highlight-copy">
					<p class="highlight-icon">
						<span class="icon <?php echo $icon; ?>"></span>
					</p>
					<h3><?php echo $title; ?></h3>
					<div class="inner-copy">
						<p><?php echo $text; ?></p>
						<p class="cta">
							<a href="<?php echo $button_link; ?>"<?php echo $target; ?>>
								<span><?php echo $button_text; ?></span>
							</a>
						</p>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

		<?php get_template_part('content', 'partners'); ?>
	</div>
</section>

<?php get_footer(); ?>
