<?php
/**
 *  Template Name: Claim An Order
 */
?>

<?php get_header(); ?>

<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post(); 
					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		
		<?php if(is_user_logged_in()) : ?>
			<h2>You are logged in</h2>
			<?php 
				global $current_user;
      			get_currentuserinfo();
      			
      			echo do_shortcode('[featured_products per_page="1" columns="1"]');
      			echo do_shortcode('[woocommerce_view_order]');

            ?>
		<?php else : ?>
			<h2>Please sign up with the email we send the order to</h2>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();