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
				<div class="refNumberForm">
					<h3>Please enter the reference # to pay for an order</h3>

					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ut commodi vero quae velit dignissimos facere. Dolor aperiam, eligendi doloremque atque mollitia inventore voluptates a unde libero assumenda accusamus nostrum.</p>

					<form action="<?php echo site_url().'/accept-order' ?>" method="post" class="roundedSearchForm">
						<input type="text" name="ref_number" id="ref_number" />
						<!-- <input type='hidden' name='action' value='submit-form' /> -->
						
						<?php wp_nonce_field('new-ref-number'); ?>
						
						<input type="submit" value="submit" class="bigSubmitButton">
					</form>
				</div>
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