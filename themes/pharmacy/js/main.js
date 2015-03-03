// equalize the main content and the side bar height

(function($){
	$(document).ready(function() {
		
		// console.log("the function is ready for use");

		var equalHeight = function() {
			var primary = $('#primary');
			var secondary = $('#secondary');
			var primaryHeight = primary.outerHeight();
			var secondaryHeight = secondary.outerHeight();

			var maxHeight = Math.max(primaryHeight, secondaryHeight);

			primary.outerHeight(maxHeight);
			secondary.outerHeight(maxHeight);
		};

		setTimeout(function(){
			equalHeight();
		}, 500);

		var menu = $(".nav-menu li");

		menu.on('click mouseover', function() {
			$(this).find('.sub-menu').show();
		});

		menu.on('mouseleave', function() {
			$(this).find('.sub-menu').hide();
		});

		var hampersDesc = "<p>Send friends and family in Zimbabwe some love from any part of the world with a beautifully handcrafted hamper today. Our selection is available in various sizes to cover every option, from the larger premium class products to the smaller products, just to say you really care.</p>";
		var otcDesc = "<p>We are your convenient and cost-effective one stop shop for Over The Counter medications (OTC). Unlike prescription medications, these products that do not require a physician issued prescription before a sale can be made.</p>";

		$(".sub-menu li a:contains('hampers')").prepend("<div class='hamperNavLiImage subListImage'></div>");
		$(".sub-menu li a:contains('hampers')").append(hampersDesc);

		$(".sub-menu li a:contains('Over The Counter')").prepend("<div class='otcNavLiImage subListImage'></div>");
		$(".sub-menu li a:contains('Over The Counter')").append(otcDesc);

		$('.flexslider').flexslider({
	        animation: "fade",
	        nextText: "",
	        slideshowSpeed: 15000,
	        controlNav : true
	    });

	});
})(jQuery);

