<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    thead, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    thead {
        background-color: #4CAF50;
        color: white;
    }
</style>
<table>
	<thead>
	<tr>
			<th>SL</th>															
			<th>Student ID</th> 
			<th>Name</th> 
            <th>Class</th>			
			<th>Section</th>											
     		<th>Group</th>									
			<th>Roll</th> 
			<th>Contact</th> 
		</tr>
	</thead>
	<tbody>
	   <?php $sl=0; ?>	
		
	    @if(isset($data['studentsViewPrint']))
		@foreach($data['studentsViewPrint'] as $irt)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->system_generated_student_id }}</td>		 
			<td>{{ $irt->student_name }}</td>		 
			<td>{{ $irt->ClassName }}</td>							
			<td>{{ $irt->SectionName }}</td>							
			<td>{{ $irt->GroupName }}</td>					
			<td>{{ $irt->roll_no }}</td>	
			<td>{{ $irt->contact_for_sms }}</td>	
		</tr>	       	
		@endforeach
		@endif 
	</tbody>
 </table>
 
 
 
 
 