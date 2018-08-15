 $(function(){		 
 $(document).on('click', '#income_report_submit', function () {
		//alert('hi');return false;
		var from_date    = $('#from_date').val();
		var to_date      = $('#to_date').val();
		var branch_and_version = $('#branch_and_version').val();
		var class_name   = $('#class_name').val();
		var section_name = $('#section_name').val();
		var group_name   = $('#group_name').val();
		var student_id   = $('#student_id').val();
		var head_name    = $('#head_name').val();
		var bank_name    = $('#bank_name').val();        //		var sub_head_name    = $('#sub_head_name').val();
		
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/IncomeReport/View' ,
			type   : 'GET',		
			data   : $('#income_report_form').serialize(),
			success: function(response){
				$('#income_report_table').html(response);
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
	
	   // ------ id ------  //
	
	$(document).on('change', '#section_name,#branch_and_version', function () {
             
        var section_name = $('#section_name').val();
        var branch_and_version = $('#branch_and_version').val();
		
		  //alert(branch_and_version);return false;
		  
        if (section_name && branch_and_version) {
            $.ajax({
                url: baseURL + 'AuthenticatedUser/IncomeReport/View/GetStudentIdBySectionIdBranchID/' + section_name + '/'+branch_and_version,
                type: 'GET',
                success: function (response) {
                    $('#student_id').html(response);
                }
            });
        }else{
            $('#student_id').html('<option value="">----- Select -----</option>');
        }
    });

	                     // ------ head ------  //

/* 	$(document).on('change', '#class_name', function () {
               //alert('class ok');return false;
        var class_name = $('#class_name').val();		
        if (class_name) {
            $.ajax({
                url: baseURL + 'AuthenticatedUser/IncomeReport/View/GetHeadNameByClassID/' + class_name,
                type: 'GET',
                success: function (response) {
                    $('#head_name').html(response);
                }
            });
        }else{
            $('#head_name').html('<option value="">----- Select -----</option>');
        }
    });
	  */
//	$(document).on('change', '#class_name,#branch_and_version', function () {
//               //alert('class ok');return false;
//			   
//        var class_name = $('#class_name').val();		
//        var branch_and_version = $('#branch_and_version').val();	
//		
//        if (class_name && branch_and_version) {
//            $.ajax({
//                url: baseURL + 'AuthenticatedUser/IncomeReport/View/GetHeadNameByClassID/' +  branch_and_version+ '/'+ class_name,
//                type: 'GET',
//                success: function (response) {
//                    $('#head_name').html(response);
//                }
//            });
//        }else{
//            $('#head_name').html('<option value="">----- Select -----</option>');
//        }
//      }); 			
 
  
});	