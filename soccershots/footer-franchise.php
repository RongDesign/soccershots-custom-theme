<?php
/**
 * @package SOCCERSHOTS
 */

$copyright = get_option('soccershots_footer_copyright');
?>
	<footer id="footer">
		<div id="copyright">
			<div class="container cf">
				<p id="copyright-tagline">
					Copyright &copy; <?php echo date('Y'); ?> <?php echo $copyright; ?>
				</p>

				<?php soccershots_custom_menu('franchise-copyright-menu', 'corporate-secondary-menu', 'copyright-list1', 'clist cf'); ?>

				<p id="returnto">
					<a href="/">
						<span class="icon icon-stadium"></span>
						View www.SoccerShots.org
					</a>
				</p>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
