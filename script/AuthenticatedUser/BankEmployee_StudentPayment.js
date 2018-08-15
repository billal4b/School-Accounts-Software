$(document).ready(function () {
    $('#view_slip_btn').click(function () {
        //$('#student_info').show();
        var studentId = $('#student_id').val() || 0;
        var generateMonth = $('#generate_month').val() || 0;
        //console.log(studentId);
        
        var url = baseURL + 'AuthenticatedUser/BankEmployee/StudentPayment/Slip/View/' + studentId + '/' + generateMonth;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response){
                //console.log(response);
                $('#student_info').html(response);
            }
        });
    });
});