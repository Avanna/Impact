(function($){
	$(document).ready(function() {

		// Show or hide hospital info on page load

		var orderTypeSelected = $("#order_type").val();

		(orderTypeSelected === 'hospital_bill') ? showHospitalFields() : hideHospitalFields();
		
		// console.log("the function is ready for use");
		$("#patient_name_lookup").on('paste keyup', function(e){
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
		               			var listItem = '<li><a data-id="' +  results[x]['postId'] + '" data-name="' + results[x]['name'] + '" href="#">'+ results[x]['name'].replace(regex, "<b>" + lookUpVal + "</b>") + '</a><p>Patient ID : <b> ' + x + '</b></p></li>';
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
			e.preventDefault();
			var clicked = $(this);
			var name = clicked.data('name');
			var id = clicked.data('id');

			$.post(ipAjax.ajaxurl, { action: 'ip_get_post', postId: id}, function(data){
				var html = '';
					html += '<h3>' + data['patient_name'] + '</h3>';
					html += '<p><b>Date of birth:</b> ' + data['DOB'] + '</p>';
					html += '<p><b>Phone:</b> ' + data['phone'] + '</p>';
					html += '<p><b>Email:</b> ' + data['email'] + '</p>';
					html += '<p><b>Address:</b> ' + data['address'] + '</p>';
				$("#patientInfo").html(html);
				$("#patient_id").val(id);
			}, 'json');

			$("#searchResults").empty();
		});

		$(document).on('paste keyup', '#hospital_name_lookup', function(e){
			e.preventDefault();

			var lookUpVal = $(this).val();
			console.log(lookUpVal);

			if(lookUpVal.length >= 3) {

				$.ajax({
	               	type: 'POST',
	               	url: ipAjax.ajaxurl,
	               	data: {
	                   action: 'get_hospitals',
	                   searchVal: lookUpVal
	        		},
	   
	               	success: function(data, textStatus, XMLHttpRequest) {

	               		var ul = $('<ul>');

	               		var results = $.parseJSON(data);

	               		if($.isEmptyObject(results)) {
	               			$("#hospitalResults").html('<p class="red">No hospital found please enter hospital into system first then place order');
	               		} else {
	               			for(x in results) {
	               				var regex = new RegExp( '(' + lookUpVal.trim() + ')', 'gi' );
		               			console.log(x);
		               			var listItem = '<li><a data-id="' +  results[x]['postId'] + '" data-name="' + results[x] + '" href="#">'+ results[x]['name'].replace(regex, "<b>" + lookUpVal + "</b>") + '</a><p>Hospital ID : <b> ' + x + '</b></p></li>';
		               			ul.append(listItem);
	               			}
							$("#hospitalResults").html(ul);
	               		}
	               	},
	               	error: function(MLHttpRequest, textStatus, errorThrown) {
	                   alert(errorThrown);
	               	}
           		});	
			} else {
				$("#hospitalResults").empty();
			}
		});

		$(document).on('click', '#hospitalResults a', function(e) {
			e.preventDefault();
			var clicked = $(this);
			var name = clicked.data('name');
			var id = clicked.data('id');

			$.post(ipAjax.ajaxurl, { action: 'ip_get_post', postId: id}, function(data){
				var html = '';
					html += '<h3>' + data['hospital_name'] + '</h3>';
					html += '<p><b>Phone:</b> ' + data['phone'] + '</p>';
					html += '<p><b>Email:</b> ' + data['email'] + '</p>';
					html += '<p><b>Address:</b> ' + data['address'] + '</p>';
				$("#hospitalInfo").html(html);
				$("#hospital_id").val(id);
			}, 'json');

			$("#hospitalResults").empty();

		});

		$("#order_type").on('change', function(e) {
			if($(this).val() === "hospital_bill") {
				showHospitalFields();
			} else {
				hideHospitalFields();
			}
		});

		function showHospitalFields() {
			$('#hospitalFieldsWrapper').show('slow');
		}

		function hideHospitalFields() {
			$('#hospitalFieldsWrapper').hide('slow');
		}
	});
})(jQuery);