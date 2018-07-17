<?php
/**
 * Template Name: Franchise: Interior
 */

$class = '';
if (is_page('enroll')) {
	$class = ' class="full-col"';
}
?>
<?php get_header(); ?>

<?php get_template_part('header', 'franchise'); ?>

<?php get_template_part('content', 'hero'); ?>

<section id="section-<?php echo $post->post_name; ?>">
	<div class="container cf">
		<div id="main-content"<?php echo $class; ?>>
			<?php if (is_page('enroll')): ?>
				<?php get_template_part('page', 'enroll'); ?>
			<?php elseif (is_page('meet-the-coaches')): ?>
				<?php get_template_part('page', 'coaches'); ?>
			<?php endif; ?>

			<?php get_template_part('content', 'modules'); ?>
		</div>

		<?php if ($class == ''): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</section>

<?php get_footer('franchise'); ?>
