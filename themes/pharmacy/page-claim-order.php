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
				endwhile;
			?>
		
			<?php if(is_user_logged_in()) : ?>
				<h2>You are logged in</h2>

				<p>Please enter the reference # to pay for an order</p>

				<form action="<?php echo site_url().'/accept-order' ?>" method="post">
					<input type="text" name="ref_number" id="ref_number" />
					<!-- <input type='hidden' name='action' value='submit-form' /> -->
					
					<?php wp_nonce_field('new-ref-number'); ?>
					
					<input type="submit" value="submit">
				</form>
				<?php 
					global $woocommerce;
					global $current_user;
	      			get_currentuserinfo();

	      			echo do_shortcode('[featured_products per_page="12" columns="4"]');
	      			echo do_shortcode('[woocommerce_view_order]');

	            ?>
			<?php else : ?>
				<h3 class="centered">Please login to continue or <a href="<?php echo site_url('/wp-login.php?action=register&redirect_to=' . get_permalink()); ?>" title="">create an account</a> </h3> 
				<?php 
					$args = array(
		        				//'redirect' => site_url().'/clients', 
						        'form_id' => 'loginform-page',
						        'label_username' => __( 'Username' ),
						        'label_password' => __( 'Password' ),
						        'label_log_in' => __( 'Log In' ),
						        'remember' => false
						    );

		    		wp_login_form( $args );
	    		?>
			<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();