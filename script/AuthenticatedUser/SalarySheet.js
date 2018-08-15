$(function () {

    $(document).on('click', '#processSalarySheet', function () {

//        alert('hi');return false;
        var month         = $('#month').val();
        var userRoleId    = $('#user_role').val();
        var branchVersion = $('#branch_version').val();
		//alert(branchVersion);return false;
        if (month && userRoleId && branchVersion) {

            $.ajax({
                url: baseURL + 'AuthenticatedUser/SalarySheet/Process/' + month + '/' + userRoleId + '/' + branchVersion,
                type: 'GET',
                success: function (response) {
                    $('#salarySheetInfo').html(response);
                },
                error: function(response){
                    console.log(response);
                }
            });
        }

    });
    
    $(document).on('click', '#viewSalarySheet', function () {

//        alert('hi');return false;
        var month         = $('#month').val();
        var userRoleId    = $('#user_role').val();
		var branchVersion = $('#branch_version').val();
        if (month && userRoleId && branchVersion) {

            $.ajax({
                url: baseURL + 'AuthenticatedUser/SalarySheet/View/' + month + '/' + userRoleId + '/' + branchVersion,
                type: 'GET',
                success: function (response) {
                    $('#salarySheetInfo').html(response);
                }
            });
        }

    });


});	