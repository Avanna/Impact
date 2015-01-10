<?php
/**
 * Template Name: Impact Pharmacy Homepage
 *
 */

get_header(); ?>
	
<div id="mainPageContent">
	
	<div id="frontPageRefNum">
		<div class="frontCategory first"><h3>Shop Hampers</h3></div>
		<div class="frontCategory last"><h3>Shop Over The Counter Medications</h3></div>
	</div> 

	<div id="patientServices">
		<div class="patientService prescriptions">
			<div id="prescriptionsLeft">
				<h2>prescriptions online</h2>
				<p>You can now buy prescription medications for friends and family in Zimbabwe online.
					Prescriptions Online™ is easy, safe, and convenient.
				</p>
				<a class="orange_button" href="<?php echo site_url().'/prescriptions' ?>">more on prescriptions</a>
			</div>
			<!-- <div id="prescriptionsRight">
				<p>Pay Online</p>
			</div> -->
		</div>
		<div class="patientService hospitalBills">
			<h2>hospital bills</h2>
			<p>Hospital Bill Pay™ is quicker, easier and cheaper than wiring or transferring money to friends and family in Zimbabwe to cover medical expenses. You can Pay any hospital, clinic, or doctor in Zimbabwe from anywhere in the world, anytime.
			</p>
			<a class="orange_button" href="<?php echo site_url().'/hospital-bills' ?>">more on hospital bills</a>
		</div>
	</div>

	<div id="mainPageShop">
		<h2>shop over the counter medications</h2>
		<?php echo do_shortcode('[featured_products per_page="3" columns="3"]'); ?>
		<?php echo do_shortcode('[recent_products per_page="3" columns="3"]'); ?>
	</div><!-- mainPageShop -->
	
</div><!-- mainPageContent -->

<?php get_footer(); ?>