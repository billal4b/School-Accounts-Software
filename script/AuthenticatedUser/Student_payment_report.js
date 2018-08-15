 $(function(){
 $(document).on('click', '#payment_report_view', function () {
		//alert('hi');return false;
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/StudentReport/View/' + from_date + '/' + to_date,
			type   : 'GET',		
			data   : $('#student_report_form').serialize(),
			success: function(response){
				$('#received_student_payments_report').html(response);
			}
		});
		 return false;
	});		
	
    $(document).on('click', '.confirm-btn', function () {console.log($(this).attr('id'));
	           
			   		   
		var receiptNo = $(this).attr('id');
		
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/StudentReport/Confirm/' + receiptNo,
			type   : 'GET',
			success: function(response){//alert(response);
				$('#received_student_payments_report').html(response);
			}
		});
		setTimeout(function(){
                var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		//alert(from_date + '----' + to_date);return;
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/StudentReport/View/' + from_date + '/' + to_date,
			type   : 'GET',		
			data   : $('#student_report_form').serialize(),
			success: function(response){
				$('#received_student_payments_report').html(response);
			}
		});
		}, 1000);
		
		 
	});	
$(document).on('click', '.clck', function(){
	alert($(this).attr('id'));
});
});	

