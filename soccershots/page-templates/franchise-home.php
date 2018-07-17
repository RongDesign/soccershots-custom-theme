<?php
/**
 * Template Name: Franchise: Home
 */

get_header();

$topMostFranchisePageId   = get_post_top_ancestor_id();
$topMostFranchisePageSlug = get_post($topMostFranchisePageId)->post_name;
$settingsID               = get_franchise_settings_id($topMostFranchisePageSlug);
$franchise_root_path      = get_permalink($topMostFranchisePageId);
$home_highlight1          = get_option('soccershots_home_highlight1');
$home_highlight2          = get_option('soccershots_home_highlight2');
$home_highlight3          = get_option('soccershots_home_highlight3');
$home_video               = get_option('soccershots_home_video');
$highlights               = array($home_highlight2, $home_highlight1, $home_highlight3);
$title1                   = get_field('title1');
$title2                   = get_field('title2');
$show_from_the_sidelines  = get_field('show_from_the_sidelines');
?>
<?php get_template_part('header', 'franchise'); ?>

<section id="section-home">
	<?php get_template_part('content', 'hero-slideshow'); ?>

	<div class="container">
		<h2><?php echo $title1; ?> <span><?php echo $title2; ?></span></h2>
		<?php the_content(); ?>

		<div class="col-wrapper cf">
			<div class="col1">
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
					<li>
						<div class="highlight-copy-wrapper" style="background-image: url('<?php echo $imagesrc[0]; ?>');">
							<div class="highlight-copy">
								<p class="highlight-icon">
									<span class="icon <?php echo $icon; ?>"></span>
								</p>
								<h3><?php echo $title; ?></h3>
							</div>
						</div>
						<p class="synopsis"><?php echo $text; ?></p>
						<p class="cta-dark">
							<a href="<?php echo $button_link; ?>"<?php echo $target; ?>>
								<span><?php echo $button_text; ?></span>
							</a>
						</p>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>

				<?php if ($home_video): ?>
				<?php
					$title             = get_the_title($home_video);
					$poster            = get_field("poster", $home_video);
					/*
					GET IMG TAG, USE: wp_get_attachment_image($id,'custom-size-name')
					GET IMG SRC, USE: wp_get_attachment_image_src($image,'homepage-highlight'); // returns array: [0]=url,[1]=width,[2]=height
					*/
					$postersrc         = wp_get_attachment_image_src($poster,'franchise-home-video');

					$youtube_video_url = get_field("youtube_video_url", $home_video);
					$copy              = get_field("copy", $home_video);
				?>
				<h3><?php echo $title; ?></h3>
				<div class="video-outer-wrapper">
					<div class="video-wrapper">
						<div class="videos-module-mask">
							<div class="ytplayer"></div>
						</div>
						<p class="videos-module-poster">
							<a href="<?php echo $youtube_video_url; ?>" target="_blank">
								<img src="<?php echo $postersrc[0]; ?>" width="<?php echo $postersrc[1]; ?>" height="<?php echo $postersrc[2]; ?>" alt="<?php echo $title; ?>" class="slideshow-poster">
								<span class="icon icon-play"></span>
							</a>
						</p>
					</div>
					<?php if ($copy): ?>
					<p><?php echo $copy; ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>

			<aside class="col2">
				<div class="home-callout enroll-callout">
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

				<?php if ($show_from_the_sidelines): ?>
				<h3>From the Sidelines</h3>
				<div class="home-callout from-the-sidelines-callout mCustomScrollbar">
					<?php
						include TEMPLATEPATH . "neosmart-stream/setup.php";
						$nss->streamCSS();
						$nss->includeFile('jquery.js');
						$nss->streamJS();
						$nss->setGroup($settingsID);
						$nss->show();
					?>
				</div>
				<?php endif; ?>
			</aside>
		</div>

		<?php get_template_part('content', 'partners'); ?>
	</div>
</section>

<?php get_footer('franchise'); ?>
