<?php
/**
 *  Template Name: prescriptions
 */
?>

<?php get_header(); ?>

<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="prescriptions-top" class="sliced-top">
			<h2><?php the_title(); ?></h2>
		</div><!-- #about-top -->

		<div id="content" class="site-content" role="main">	

			<?php get_template_part("refNumLink") ?>

			<?php while(have_posts()): the_post(); ?>	
				<?php the_content(); ?>	
			<?php endwhile; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();