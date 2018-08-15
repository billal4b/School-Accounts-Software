 $(function(){

     function getBranchSection(class_id = null, branch_and_version = null){
         if (class_id && branch_and_version) {
             $.ajax({
                 url: baseURL + 'AuthenticatedUser/AppSetup/Student/create/' + branch_and_version  + '/'+ class_id,
                 type: 'GET',
                 success: function (response) {
                     $('#section_name').html(response);
                 }
             });
         }else{
             $('#section_name').html('<option value="">----- Select -----</option>');
         }
     }
	
	$(document).on('change', '#branch_and_version, #class_id', function () {
		//alert('hi');return false;
             
        var class_id = $('#class_id').val();
        var branch_and_version = $('#branch_and_version').val();
		
		  //alert(class_id);return false;
		  //alert(branch_and_version);return false;
		  
        getBranchSection(class_id, branch_and_version);
    });

     getBranchSection($('#class_id').val(), $('#branch_and_version').val());
    // alert(section_id);

     setTimeout(function(){
         //document.getElementById('section_name').value = section_id; alert(section_id); }, 3000
document.getElementById('section_name').value = $('#SectionID').val(); }, 3000
     );
     document.getElementById('section_name').value = $('#SectionID').val();
     
});	
