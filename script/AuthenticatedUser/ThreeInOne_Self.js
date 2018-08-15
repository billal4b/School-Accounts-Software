$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('change', '#head_name', function () {

        var headName = $(this).val();
        if (headName != null || headName != '') {
            $.ajax({
                url: baseURL + 'AuthenticatedUser/ThreeInOne/GetAccountingSubHeadsByAccountingHeadId/' + headName,
                type: 'GET',
                success: function (response) {
                    $('#subHeadLists').html(response);
                }
            });
        } else {
            $('#subHeadLists').html('');
            return false;
        }
    });
    $(document).on('blur', '.units, .unit_prices', function () {

        var rowNumber = $(this).closest("tr")[0].rowIndex;
        var totalRow = $('#subHeadTable tbody tr').length;
        //console.log(totalRow);
        //console.log(rowNumber);
        var unit = $('#subHeadTable').find('tr:eq(' + rowNumber + ') td:eq(1)').find('.units').val();
        //console.log(unit);
        var price = $('#subHeadTable').find('tr:eq(' + rowNumber + ') td:eq(2)').find('.unit_prices').val();
        //console.log(price);
        if (unit != '' || price != '') {
            $('#subHeadTable').find('tr:eq(' + rowNumber + ') td:eq(3)').find('.total').html(unit * price);

        }
        var gtotal = 0;
        for (var i = 0; i < totalRow; i++){
            gtotal += parseFloat($('#subHeadTable tbody').find('tr:eq(' + i + ') td:eq(3)').find('.total').text());
            console.log(gtotal);
        }
        $('#gtotal').html(gtotal);

    });

    $(document).on('change', 'input[type=radio][name=payment_type]', function () {

        //alert($(this).val());
        var payment_type = $(this).val();
        if (payment_type == "check"){
            $('#bank_info').show();
        } else{
            $('#bank_info').hide();
        }
    });
	
	
	
	
	
});

