 $(function(){		 
 $(document).on('click', '#expense_report_submit', function () { 
		//alert('hi');return false;	
		var from_date    = $('#from_date').val();
		var to_date      = $('#to_date').val();
		var payment_type = $('#payment_type').val();
		var head_name    = $('#head_name').val();		
		//alert(head_name);return false;		
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/ExpenseReport/View',
			type   : 'GET',		
			data   : $('#expense_report_form').serialize(),
			success: function(response){
				$('#expense_report_table').html(response);
			}
		});	 
	});	 
});	
