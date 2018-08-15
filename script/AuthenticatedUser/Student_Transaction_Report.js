$(document).ready(function () {		 
            
 $(document).on('change', '#monthSelect', function () {
         // alert('ok');return;
		 
		var class_id 		  = $('#class_id').val(); 
		var group_id 		  = $('#group_id').val(); //alert( group_id );return;
		var ibv_id   		  = $('#ibv_id').val();
		var month             = $(this).val();   
		var student_id 		  = $('#student_id').val(); 
		var actual_student_id = $('#actual_student_id').val();
		
               
				
		if (class_id && group_id && ibv_id && month) {
			$.ajax({
				url: baseURL + 'AuthenticatedUser/StudentTransactionReport/MonthWiseStudentTransactionSlip/' +
                class_id + '/' + group_id + '/' + ibv_id + '/' + month + '/' + student_id + '/' +actual_student_id, 
				
				type: 'GET',
				success: function (response) {
					$('#viewMonthWise_Student_Transaction_table').html(response);
				}
			});
		} else {
			$('#viewMonthWise_Student_Transaction_table').html('<strong class="text-danger  text-center">NO DATA FOUND.</strong>');
		}
	});

	

  
});	