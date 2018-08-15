 $(function(){		 
 $(document).on('click', '#income_report_in_all_submit', function () {
		//alert('hi');return false;
		var from_date           = $('#from_date').val();
		var to_date             = $('#to_date').val();
		var class_name          = $('#class_name').val();
		var group_name          = $('#group_name').val();
		var student_id          = $('#student_id').val();
		var bank_name           = $('#bank_name').val();
		var branch_version_name = $('#branch_version_name').val();
		//var head_name    = $('#head_name').val();
		//var section_name = $('#section_name').val();
		
		
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/IncomeReportInAll/View' ,
			type   : 'GET',		
			data   : $('#income_report_in_all_form').serialize(),
			success: function(response){
				$('#income_report_in_all_table').html(response);
			}
		});
		 
	});	
	$(document).on('change', '#group_name', function () {
             
        var class_name = $('#class_name').val();
        var group_name = $('#group_name').val();
		
		  //alert(group_name);return false;
		  
        if (class_name && group_name) {
            $.ajax({
                url: baseURL + 'AuthenticatedUser/IncomeReportInAll/View/GetStudentIdByClassIDSectionIdGroupID/' + class_name + '/'+group_name,
                type: 'GET',
                success: function (response) {
                    $('#student_id').html(response);
                }
            });
        }else{
            $('#student_id').html('<option value="">----- Select -----</option>');
        }
    });	 
  
});	