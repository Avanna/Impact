(function($){
	$(document).ready(function() {
		
		// console.log("the function is ready for use");
		$("#patient_name").on('paste keyup', function(e){
			e.preventDefault();

			var lookUpVal = $(this).val();
			console.log(lookUpVal);

			if(lookUpVal.length >= 3) {

				$.ajax({
	               	type: 'POST',
	               	url: ipAjax.ajaxurl,
	               	data: {
	                   action: 'get_patients',
	                   searchVal: lookUpVal
	        		},
	   
	               	success: function(data, textStatus, XMLHttpRequest) {

	               		var ul = $('<ul>');

	               		var results = $.parseJSON(data);

	               		if($.isEmptyObject(results)) {
	               			$("#searchResults").html('<p class="red">No patient found please enter patient into system first then place order');
	               		} else {
	               			for(x in results) {
	               				var regex = new RegExp( '(' + lookUpVal.trim() + ')', 'gi' );
		               			console.log(x);
		               			var listItem = '<li><a data-name="' + results[x] + '" href="#">'+ results[x].replace(regex, "<b>" + lookUpVal + "</b>") + '</a><p>Patient ID : <b> ' + x + '</b></p></li>';
		               			ul.append(listItem);
	               			}
							$("#searchResults").html(ul);
	               		}
	               	},
	               	error: function(MLHttpRequest, textStatus, errorThrown) {
	                   alert(errorThrown);
	               	}
           		});	
			} else {
				$("#searchResults").empty();
			}
		});

		$(document).on('click', '#searchResults a', function(e) {
			e.preventDefault;
			console.log('clicked', e);
			var val = $(this).data('name');
			$("#patient_name").val(val);

			$("#searchResults").empty();

		});

	});
})(jQuery);