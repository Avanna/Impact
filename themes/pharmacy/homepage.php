<?php
/**
 * Template Name: Impact Pharmacy Homepage
 *
 */

get_header(); ?>
	
<div id="mainPageContent">
	<div id="patientServices">
		<div class="patientService">
			<h2>prescriptions online</h2>
			<p>You can now buy prescription medications for friends and family in Zimbabwe online.
				Prescriptions Online™ is easy, safe, and convenient.
			</p>
			<a href="#">Pay for Prescriptions</a>
		</div>
		<div class="patientService">
			<h2>hospital bills</h2>
			<p>Hospital Bill Pay™ is quicker, easier and cheaper than wiring or transferring money to friends and family in Zimbabwe to cover medical expenses. You can Pay any hospital, clinic, or doctor in Zimbabwe from anywhere in the world, anytime.
			</p>
			<a href="#">pay a hospital bill</a>
		</div>
	</div>

	<div id="mainPageShop">
		<h2>shop over the counter medications</h2>
		<?php echo do_shortcode('[featured_products per_page="3" columns="3"]'); ?>
		<?php echo do_shortcode('[recent_products per_page="3" columns="3"]'); ?>
	</div><!-- mainPageShop -->
	
</div><!-- mainPageContent -->


<?php get_footer(); ?>