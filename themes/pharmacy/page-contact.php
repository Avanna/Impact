<?php
/**
 *  Template Name: Contact
 */
?>

<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div id="intro">
		<h2><?php the_title(); ?></h2>
	</div>

	<div id="primary" class="content-area">

		<div id="content" class="site-content" role="main">	
			<?php while(have_posts()): the_post(); ?>	
				<?php the_content(); ?>	
			<?php endwhile; ?>
		</div><!-- #content -->
		
		<div id="contactForm">
			<h3>Send us an email</h3>
			<?php echo do_shortcode('[contact-form-7 id="292" title="Contact form 1"]'); ?>
		</div>

		<div id="contactMap">
			<h3>Get Directions</h3>
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15194.434363582985!2d31.03322379151258!3d-17.81008326244956!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1931a51cf0bcf069%3A0xf54cf1e14e716386!2sBaines+Ave%2C+Harare%2C+Zimbabwe!5e0!3m2!1sen!2sus!4v1425352966383" width="727" height="500" frameborder="0" style="border:0"></iframe>
		</div>
		
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();