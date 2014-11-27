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
							$user_id = get_current_user_id();

							update_post_meta( $order_id, '_customer_user', $user_id );

							echo "<p>this order was requested by ".get_post_meta($order_id, 'order_requester', true);

							// print_r($my_query);
						}

					} else {
						echo 'Sorry no orders match that reference number. Please try again';
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