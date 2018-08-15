 $(function(){		 

 $(document).on('click', '#students_view_submit', function () {
             //alert('hi');return false;
		var search_value       = $('#search_value').val();		  
		var branch_and_version = $('#branch_and_version').val();		  
		var class_name         = $('#class_name').val();
		var section_name       = $('#section_name').val();
		var group_name         = $('#group_name').val();
  
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/StudentwisePaymentReport/View' ,			
			type   : 'POST',		
			data   : $('#students_view_form').serialize(),			 
			success: function(response){
				$('#students_view_table').html(response);
			}
			
		});
	});	
	
               // ------ section ------  //
			   
	$(document).on('change',  '#branch_and_version, #class_name', function () {

        var class_name         = $('#class_name').val();
        var branch_and_version = $('#branch_and_version').val();

		  //alert(branch_and_version);return false;

         if (class_name && branch_and_version) {
             $.ajax({
                 url: baseURL + 'AuthenticatedUser/StudentwisePaymentReport/' + branch_and_version  + '/'+ class_name,
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