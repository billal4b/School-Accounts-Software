$(function () {

    $(document).on('change', '#accounting_category', function () {

        var headName = $(this).val();
        if (headName != null || headName != '') {
            $.ajax({
                url: baseURL + 'AuthenticatedUser/AppSetup/AccountingSubHead/GetHeadNameByAccountingCategoryId/' + headName,
                type: 'GET',
                success: function (response) {
                    $('#head_name').html(response);
                }
            });
        }else{
            $('#head_name').html('<option value="">----- Select -----</option>');
        }
        return;
    });
});

