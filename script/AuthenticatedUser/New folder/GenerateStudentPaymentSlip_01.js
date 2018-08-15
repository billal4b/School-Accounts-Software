$(document).ready(function () {

    $('#view_slip_btn').click(function () {
        //$('#student_info').show();
        var studentId = $('#student_id').val() || 0;
        var generateMonth = $('#generate_month').val() || 0;
        var receiptNo = $('#receipt_no').val() || 0;
        //console.log(studentId);

        var url = baseURL + 'AuthenticatedUser/GenerateStudentPaymentSlip/View/' + studentId + '/' + generateMonth + '/' + receiptNo;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                //console.log(response);
                $('#student_info').html(response);
            }
        });
        return false;
    });


    $(document).on('keydown', '#received_amount', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: Ctrl+C
                                (e.keyCode == 67 && e.ctrlKey === true) ||
                                // Allow: Ctrl+X
                                        (e.keyCode == 88 && e.ctrlKey === true) ||
                                        // Allow: home, end, left, right
                                                (e.keyCode >= 35 && e.keyCode <= 39)) {
                                    // let it happen, don't do anything
                                    return;
                                }
                                // Ensure that it is a number and stop the keypress
                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                    e.preventDefault();
                                }
                            });

                    $(document).on('keyup', '#received_amount', function (e) {
                        //alert(this.value);return;
                        var receivedAmount = this.value || 0;
                        var due = 0;
                        if (receivedAmount != null || receivedAmount != '') {
                            due = parseFloat(grandTotal) - parseFloat(receivedAmount);
                            //console.log(due);
                            document.getElementById('due_amount').innerHTML = due;
                        } else {
                            //console.log(parseFloat(grandTotal));
                            document.getElementById('due_amount').innerHTML = parseFloat(grandTotal);
                        }
                        e.preventDefault();
                    });




                    $(document).on('click', '#payBtn', function () {

			$(this).attr("disabled", true);
                        var received_amount = $('#received_amount').val();
                        var book_sl_no = $('#book_sl_no').val();
                        if (received_amount && received_amount.length > 0 && book_sl_no && book_sl_no.length > 0) {
                            $.ajax({
                                url: baseURL + 'AuthenticatedUser/GenerateStudentPaymentSlip/Pay',
                                type: 'POST',
                                data: $('#student_payment_form').serialize(),
                                success: function(response){
//alert(response);return;
                                    $('#student_info').html(response);
                                }
                            });
                        } else {
                            if(!received_amount){
                                alert('The RECEIVED AMOUNT field is required');
                            }
                            else if(!book_sl_no){
                                alert('The BOOK SL. NO. field is required');
                            }
                        }
                        return false;
                    });
                    
                    $(document).on('click', '#confirmBtn', function () {
                            $.ajax({
                                url: baseURL + 'AuthenticatedUser/GenerateStudentPaymentSlip/Confirm',
                                type: 'POST',
                                data: $('#student_payment_form').serialize(),
                                success: function(response){
                                    $('#student_info').html(response);
                                }
                            });
                        //return false;
                    });
                    
 });
