 $(function(){		 

 $(document).on('click', '#students_view_submit', function () {
             //alert('hi');return false;
		var branch_and_version = $('#branch_and_version').val();		  
		var class_name         = $('#class_name').val();
		var section_name       = $('#section_name').val();
		var group_name         = $('#group_name').val();
  
		$.ajax({
			url    : baseURL + 'AuthenticatedUser/StudentsViewAccount/View' ,			
			type   : 'POST',		
			data   : $('#students_view_form').serialize(),			 
			success: function(response){
				$('#students_view_table').html(response);
			}
			
		});
	});	
	
               // ------ section ------  //
			   
	/* $(document).on('change',  '#branch_and_version, #class_name', function () {

        var class_name         = $('#class_name').val();
        var branch_and_version = $('#branch_and_version').val();

		  //alert(branch_and_version);return false;

         if (class_name && branch_and_version) {
             $.ajax({
                 url: baseURL + 'AuthenticatedUser/StudentsViewAccount/' + branch_and_version  + '/'+ class_name,
                 type: 'GET',
                 success: function (response) {
                     $('#section_name').html(response);
                 }
             });
         }else{
             $('#section_name').html('<option value="">----- Select -----</option>');
         }
    }); */
	
	
	
	function getBranchSection(class_name = null, branch_and_version = null){
         if (class_name && branch_and_version) {
             $.ajax({
                 url: baseURL + 'AuthenticatedUser/StudentsViewAccount/edit/' + branch_and_version  + '/'+ class_name,
                 type: 'GET',
                 success: function (response) {
                     $('#section_name').html(response);
                 }
             });
         }else{
             $('#section_name').html('<option value="">----- Select -----</option>');
         }
     }
	
	$(document).on('change', '#branch_and_version, #class_name', function () {
		//alert('hi');return false;
             
        var class_name = $('#class_name').val();
        var branch_and_version = $('#branch_and_version').val();
		
		  //alert(class_name);return false;
		  //alert(branch_and_version);return false;
		  
        getBranchSection(class_name, branch_and_version);
    });

     getBranchSection($('#class_name').val(), $('#branch_and_version').val());
    // alert(section_id);

     /*setTimeout(function(){
         document.getElementById('section_name').value = section_id; }, 3000
     );*/
setTimeout(function(){
         //document.getElementById('section_name').value = section_id; alert(section_id); }, 3000
document.getElementById('section_name').value = $('#SectionID').val(); }, 3000
     );
     document.getElementById('section_name').value = $('#SectionID').val();
});	
