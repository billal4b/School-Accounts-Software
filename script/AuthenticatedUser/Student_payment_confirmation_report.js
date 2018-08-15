 $(function(){
 $(document).on('click', '#payment_confirmation_report_view', function () {
		//alert('hi');return false;
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/ConfirmationReport/View/' + from_date + '/' + to_date,
			type   : 'GET',		
			data   : $('#confirmation_report_form').serialize(),
			success: function(response){
				$('#payment_confirmation_report').html(response);
			}
		});
		 return false;
	});		
		

});	

