<?php
/**
 * @package SOCCERSHOTS
 */
?>
<?php
$social_fb = get_option('soccershots_facebook_url');
$social_tw = get_option('soccershots_twitter_url');
$social_li = get_option('soccershots_linkedin_url');
$social_yt = get_option('soccershots_youtube_url');
$copyright = get_option('soccershots_footer_copyright');
?>
	<?php if (!is_404()): ?>
		<footer id="footer">
		<div id="footer-top">
			<div class="container">
				<div class="social-container cf">
					<div class="social-container-bg"></div>
					<p id="social-tagline">Connect With Soccer Shots</p>
					<ul id="social-list" class="clist cf">
						<?php if (!empty($social_fb)) : ?>
						<li>
							<a href="<?php echo $social_fb; ?>" target="_blank">
								<span class="icon icon-facebook-square"></span>
								<span class="txt">Facebook</span>
							</a>
						</li>
						<?php endif; ?>
						<?php if (!empty($social_tw)) : ?>
						<li>
							<a href="<?php echo $social_tw; ?>" target="_blank">
								<span class="icon icon-twitter-square"></span>
								<span class="txt">Twitter</span>
							</a>
						</li>
						<?php endif; ?>
						<?php if (!empty($social_li)) : ?>
						<li>
							<a href="<?php echo $social_li; ?>" target="_blank">
								<span class="icon icon-linkedin-square"></span>
								<span class="txt">LinkedIn</span>
							</a>
						</li>
						<?php endif; ?>
						<?php if (!empty($social_yt)) : ?>
						<li>
							<a href="<?php echo $social_yt; ?>" target="_blank">
								<span class="icon icon-youtube"></span>
								<span class="txt">YouTube</span>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>

		<div id="footer-bottom">
			<div class="container">
				<?php soccershots_custom_menu('corporate-main-menu', 'corporate-main-menu-footer', 'footer-list', 'clist cf'); ?>
			</div>
		</div>

		<div id="copyright">
			<div class="container cf">
				<p id="copyright-tagline">
					Copyright &copy; <?php echo date('Y'); ?> <?php echo $copyright; ?>
				</p>

				<?php soccershots_custom_menu('corporate-copyright-menu', 'corporate-secondary-menu', 'copyright-list1', 'clist cf'); ?>

				<?php soccershots_custom_menu('corporate-secondary-menu', 'corporate-secondary-menu', 'copyright-list2', 'clist cf'); ?>

			</div>
		</div>
	</footer>
	<?php endif; ?>

	<?php wp_footer(); ?>
</body>
</html>
