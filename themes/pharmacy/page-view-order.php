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
				<?php
					if(isset($_POST['ref_number']) && $_POST['ref_number'] !== '') {
						$ref_number = $_POST['ref_number'];
						$args = array(
						  	'post_type' => 'shop_order',
						  	'post_status' => array_keys( wc_get_order_statuses() ),
						  	'meta_query' => array(
					            array(
					                'key' => 'ref_number',
					                'value' => $ref_number
					            )
					        )
						);

						$my_query = new WP_Query($args);

						if($my_query->have_posts()) {

							$order_id = $my_query->posts[0]->ID;
							$order = $my_query->posts[0];

							echo "<p>This order was requested by <b>".get_post_meta($order_id, 'patient_name', true)."</b>.</p>";

							if(get_post_meta($order_id, 'order_notes', true)) :

								echo '<h3>Note from recipient</h3>' . get_post_meta($order_id, 'order_notes', true);

							endif;

							if($order->post_status === 'wc-completed') {
								echo '<p class="impactNotice">This order has already been completed. Please contact us if you have any questions.</p>';
							}
							
							do_action( 'woocommerce_view_order', $order_id );
						?>

						<?php if($order->post_status === 'wc-completed') : ?>
							<p class="impactNotice">This order has already been completed. Please contact us if you have any questions.</p>
						<?php else : ?>
							<form action="<?php echo site_url(); ?>/my-account" method="post">
								<input type='hidden' name='order-id' value='<?php echo $order_id ?>' />
								<?php wp_nonce_field('accept-order'); ?>
								<input type="submit" value="Accept Order" class="bigSubmitButton">
							</form>
						<?php endif; ?>
						<?php
						} else {
							echo '<p>Sorry no orders match that reference number. Please double check the reference number and <a href="'.site_url().'/claim-an-order">try again</a></p>';
						}
					} else {
						echo '<p>Please enter a valid reference number</p>';
					}
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