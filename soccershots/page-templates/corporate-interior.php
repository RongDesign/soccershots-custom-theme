<?php
/**
 * Template Name: Corporate: Interior
 */

$class = '';
if (is_page('find-your-region')) {
	$class = ' class="full-col"';
}
?>
<?php get_header(); ?>

<?php get_template_part('header', 'corporate'); ?>

<?php get_template_part('content', 'hero'); ?>

<section id="section-<?php echo $post->post_name; ?>">
	<div class="container cf">


		<div id="main-content"<?php echo $class; ?>>
			<?php if (is_page('find-your-region')): ?>
				<?php get_template_part('page', 'find-your-region'); ?>
			<?php endif; ?>

			<?php get_template_part('content', 'modules'); ?>

			<?php if (is_page('sitemap')): ?>
				<div class="module module-sitemap">
					<?php /* exclude FRANCHISEE TEMPLATE (this is used by Soccer Shots to build new templates) */ ?>
					<?php echo do_shortcode('[pagelist depth="2" exclude_tree="2052"]'); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ($class == ''): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
