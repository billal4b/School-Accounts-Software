<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>

<table class="table table-striped table-bordered">
     <a class="btn btn-lg  btn-primary fa fa-print" target="_blank" style="cursor:pointer;"
	 href="{{ url(route('studentViewPrint::studentPrint', array(
                                              'branchVersion'=> Request::get('branch_and_version'),
			                                  'class'        => Request::get('class_name'),
			                                  'section'      => Request::get('section_name'),
			                                  'group'        => Request::get('group_name')
             )))  }}"> Print </a>

	<thead style="background-color: #f2f2f2;">
	<tr>
			<th>SL</th>															
			<th>Student ID</th> 
			<th>Name</th> 
            <th>Class</th>			
			<th>Section</th>											
     		<th>Group</th>									
			<th>Roll</th> 
			<th>Contact</th> 
			<th>Action</th> 
		</tr>
	</thead>
	<tbody>  
	   <?php $sl=0; ?>	
		
	    @if(isset($data['studentsView']))
		@foreach($data['studentsView'] as $irt)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->system_generated_student_id }}</td>		 
			<td>{{ $irt->student_name }}</td>		 
			<td>{{ $irt->ClassName }}</td>							
			<td>{{ $irt->SectionName }}</td>							
			<td>{{ $irt->GroupName }}</td>					
			<td>{{ $irt->roll_no }}</td>	
			<td>{{ $irt->contact_for_sms }}</td>	
<td>
   <a class="btn btn-sm btn-primary" href="{{ url(route('studentsViewAccount.edit', array(
                                                                                'id' => $irt->student_id))) }}" target="_blank">
   <i class="fa fa-pencil"></i> Update</a>
</td>
		</tr>	       	
		@endforeach
		@endif 
	</tbody>
 </table>
 
 
 
 
 