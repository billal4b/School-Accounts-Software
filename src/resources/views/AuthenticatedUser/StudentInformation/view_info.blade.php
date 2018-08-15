<table class="table table-condensed table-bordered">	
<thead>		
    <tr>			
       <th>Student ID</th>			
       <th>Student Name</th>	
		<th>Class</th>	
		<th>Roll</th>	
		<th>Group</th>		
		<th>Section</th>
		 <th>Branch</th>
        <th>Payment</th>		
		<th>Status</th>		
				
	</tr>	
</thead>
<tbody>		
		@if(isset($data['studentList']))	
			<?php $i=0; ?>	
		@foreach($data['studentList'] as $egl)		
	<tr>		
		<td>{{ $egl->system_generated_student_id }}</td>	
		<td>{{ $egl->student_name }}</td>	
		<td>{{ $egl->ClassName }}</td>	
        <td>{{ $egl->roll_no }}</td>			
		<td>{{ $egl->GroupName }}</td>		
		<td>{{ $egl->SectionName }}</td>	
		 <td>
                                                 
			 <?php
			 $query = 'select tsb.school_branch_name, tsv.school_version_name from tbl_sec_institute_branch_version tsibv inner join tbl_school_branches tsb on  tsibv.school_branch_id = tsb.school_branch_id inner join tbl_school_versions tsv on tsibv.school_version_id = tsv.school_version_id where tsibv.institute_branch_version_id = ' . $egl->institute_branch_version_id;
			 $result = DB::select($query);
			 //echo '<pre>';print_r($result);exit();
			 echo $result[0]->school_branch_name . ', ' . $result[0]->school_version_name;
			 ?>
		</td>
	  <td>{{ $egl->cash_in_hands }}</td>	
		<td><span class="label label-{{ $egl->status == 1 ? 'success' : 'danger' }}">{{ $egl->status == 1 ? 'Regular' : 'Irregular' }}</span></td>

	</tr>	
		@endforeach	
		@endif	
	</tbody>
</table>