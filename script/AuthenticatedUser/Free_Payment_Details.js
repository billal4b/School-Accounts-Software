$(function(){		 

               // ------ Head ------  //
			   
    $(document).on('change', '#class_name,#branch_and_version', function () {
               //alert('class ok');return false;
			   
        var class_name = $('#class_name').val();		
        var branch_and_version = $('#branch_and_version').val();	
		
        if (class_name && branch_and_version) {
            $.ajax({
                url: baseURL + 'AuthenticatedUser/AppSetup/FreePaymentDetails/create/' +  branch_and_version+ '/'+ class_name,
                type: 'GET',
                success: function (response) {
                    $('#head_name').html(response);
                }
            });
        }else{
            $('#head_name').html('<option value="">----- Select -----</option>');
        }
      }); 			
});	 
 
/*  $(function(){

     function getBranchSection(class_id = null, branch_and_version = null){
         if (class_id && branch_and_version) {
             $.ajax({
                  url: baseURL + 'AuthenticatedUser/AppSetup/FreePaymentDetails/create/' +  branch_and_version+ '/'+ class_name,
                 type: 'GET',
                 success: function (response) {
                     $('#head_name').html(response);
                 }
             });
         }else{
             $('#head_name').html('<option value="">----- Select -----</option>');
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
         document.getElementById('head_name').value = head_id; }, 3000
     );
    // document.getElementById('section_name').value = section_id;
     
});	  */