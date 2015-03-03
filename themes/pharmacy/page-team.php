<?php
/**
 *  Template Name: our team
 */
?>

<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">

		<!-- <div id="team-top" class="sliced-top">
			<h2><?php the_title(); ?></h2>
		</div><!-- #about-top -->

		<div id="content" class="site-content" role="main">	

			<?php get_template_part('commonTemplates/aboutLinks'); ?>

			<?php while(have_posts()): the_post(); ?>	
				<?php the_content(); ?>	
			<?php endwhile; ?>


			<div id="team">
				<?php 
	                $args = array(
	                    'category_name' => 'team',
	                    'orderby' => 'date',
						'order'   => 'ASC',
	                );

	                $q = new WP_Query($args);

	                while($q->have_posts()) : $q->the_post(); 
	            ?>
				
				<div class="teamMember">
					<div class="teamMemberPic">
						<?php if(has_post_thumbnail()) {
							the_post_thumbnail();
						} ?>
					</div>
					
					<div class="teamMemberInfo">
						<h3><?php the_title(); ?></h3>
						<p><?php the_content(); ?></p>
					</div>
				</div>

	        	<?php endwhile; wp_reset_query(); ?>
			</div><!-- team -->
			

		</div><!-- #content -->

	</div><!-- #primary -->

	<?php get_sidebar( 'content' ); ?>

</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();