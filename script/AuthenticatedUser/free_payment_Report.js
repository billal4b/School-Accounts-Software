 $(function(){		 
 $(document).on('click', '#income_report_submit', function () {
		//alert('hi');return false;
		
		var free_catagory      = $('#free_catagory').val();
		var branch_and_version = $('#branch_and_version').val();
		var class_name         = $('#class_name').val();
		var section_name       = $('#section_name').val();
		var group_name         = $('#group_name').val();
	
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/FreePaymentReport/View' ,
			type   : 'GET',		
			data   : $('#free_payment_report_form').serialize(),
			success: function(response){
				$('#free_payment_report_table').html(response);
			}
		});
		 
	});	
	
	                 // ------ section ------  //
	
	$(document).on('change',  '#branch_and_version, #class_name', function () {
             
        var class_name = $('#class_name').val();
        var branch_and_version = $('#branch_and_version').val();
		
		  //alert(class_name);return false;
		  
         if (class_name && branch_and_version) {
             $.ajax({
                 url: baseURL + 'AuthenticatedUser/IncomeReport/View/GetBranchSection/' + branch_and_version  + '/'+ class_name,
                 type: 'GET',
                 success: function (response) {
                     $('#section_name').html(response);
                 }
             });
         }else{
             $('#section_name').html('<option value="">----- Select -----</option>');
         }
    });
	

});	