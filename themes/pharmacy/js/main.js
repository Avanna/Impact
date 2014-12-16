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
	});
})(jQuery);

