<?php
/**
 *  Template Name: View An Order
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
				endwhile;
			?>
		
			<?php if(is_user_logged_in()) : ?>
				<h2>You are logged in</h2>

				<p>Here is the order for your reference #. You can pay for the order below</p>

				<form action="<?php echo get_admin_url().'admin-post.php' ?>" method="post">
					<input type="text" name="ref_number" id="ref_number" />
					<input type='hidden' name='action' value='submit-form' />
					
					<?php wp_nonce_field('new-ref-number'); ?>
					
					<input type="submit" value="submit">
				</form>
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