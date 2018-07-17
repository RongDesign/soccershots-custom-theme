<?php
/**
 * Template Name: Corporate: Interior (Parent Resources)
 */
?>
<?php get_header(); ?>

<?php get_template_part('header', 'corporate'); ?>

<?php get_template_part('content', 'hero'); ?>

<section id="section-<?php echo $post->post_name; ?>">
	<div class="container cf">
		<div id="main-content">
			<?php get_template_part('content', 'parent-resources'); ?>

			<?php get_template_part('content', 'modules'); ?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>
