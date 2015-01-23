// equalize the main content and the side bar height

(function($){
	$(document).ready(function() {
		
		// console.log("the function is ready for use");

		var equalHeight = function() {
			var primary = $('#primary');
			var secondary = $('#secondary');
			var primaryHeight = primary.height();
			var secondaryHeight = secondary.height();

			var maxHeight = Math.max(primaryHeight, secondaryHeight);

			primary.height(maxHeight);
			secondary.height(maxHeight);
		};

		equalHeight();

		var menu = $(".nav-menu li");

		menu.on('click mouseover', function() {
			$(this).find('.sub-menu').show();
		});

		menu.on('mouseleave', function() {
			$(this).find('.sub-menu').hide();
		});

		$(".sub-menu li a:contains('hampers')").prepend("<div class='hamperNavLiImage'></div>");
		$(".sub-menu li a:contains('Over The Counter')").prepend("<div class='otcNavLiImage'></div>");
	});
})(jQuery);

