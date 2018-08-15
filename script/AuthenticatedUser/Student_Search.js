$(function(){		 
	$(document).on('click', '#student_search_submit', function () {
        var search_value = $('#search_value').val();
		$.ajax({
			url: baseURL + 'AuthenticatedUser/AppSetup/Student/Search',
			type: 'POST',
			data: $('#student_form_search').serialize(),
			success: function (response) {
				$('#student_search_view').html(response);
				//alert(response);
			}
		});
    });		   
	
	  // Student information search //
	
	$(document).on('click', '#student_information_search_submit', function () {
		//alert ('00');
	   var search_value = $('#search_value').val();
	   	    $.ajax({
				url: baseURL + 'AuthenticatedUser/StudentInformation/Search',
				type: 'POST',
				data: $('#student_information_form_search').serialize(),
				success: function (response) {
					$('#student_information_search_view').html(response);
					//alert(response);
			    }
	       });
    });	
	
	
});	