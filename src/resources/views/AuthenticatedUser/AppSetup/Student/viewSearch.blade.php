<table class="table table-condensed table-bordered">
	<thead>
		<tr>		   
			<th>Student ID</th>
			<th>Student Name</th>
			<th>Class</th>
			<th>Group</th>
			<th>Section</th>
			<th>Status</th>
			<th>Action</th>
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
			<td>{{ $egl->GroupName }}</td>
			<td>{{ $egl->SectionName }}</td>
			<td><span class="label label-{{ $egl->status == 1 ? 'success' : 'danger' }}">{{ $egl->status == 1 ? 'Regular' : 'Irregular' }}</span></td>
			<td><a class="btn btn-primary btn-sm" href="{{ url(route('student.edit', array('id' => $egl->student_id))) }}"><i class="fa fa-pencil-square-o"></i>&nbsp;Update</a></td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>

