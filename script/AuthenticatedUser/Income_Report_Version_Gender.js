$(function(){		 
    $(document).on('click', '#income_report_boy_girl_submit', function () {
		//alert('hi');return false;
		var from_date    = $('#from_date').val();
		var to_date      = $('#to_date').val();
		var gender       = $('#gender').val();
		var version      = $('#version').val();
				
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/IncomeReportVersionGender/View' ,
			type   : 'GET',		
			data   : $('#boy_girl_report_form').serialize(),
			success: function(response){
				$('#income_report_boy_gril_table').html(response);
			}
		});		 
	});	
});	