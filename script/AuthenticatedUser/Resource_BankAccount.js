$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('change', '#bank_name', function () {

        var bankName = $(this).val();
        if (bankName != null || bankName != '') {
            $.ajax({
                url: baseURL + 'AuthenticatedUser/AppSetup/BankAccount/GetBranchNameByBankId/' + bankName,
                type: 'GET',
                success: function (response) {
                    $('#branch_name').html(response);
                }
            });
        }else{
            $('#branch_name').html('<option value="">----- Select -----</option>');
        }
    });
});

