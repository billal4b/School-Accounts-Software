<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>
<table class="table table-striped table-bordered">      <a class="btn btn-lg  btn-primary fa fa-print" target="_blank" style="cursor:pointer;"	 href="{{ url(route('incomeReport::incomeReportPrint', array(                                              'from_date'  => Request::get('from_date'),                                              'to_date'    => Request::get('to_date'),                                              'branch'    => Request::get('branch_and_version') == '' ? 0 : Request::get('branch_and_version'),			                                  'class'     => Request::get('class_name') == '' ? 0 : Request::get('class_name'),			                                  'section'   => Request::get('section_name') == '' ? 0 : Request::get('section_name'),			                                  'group'     => Request::get('group_name') == '' ? 0 : Request::get('group_name'),			                                  'sID'       => Request::get('student_id') == '' ? 0 : Request::get('student_id'),			                                  'head'      => Request::get('head_name') == '' ? 0 : Request::get('head_name'),			                                  'bank'      => Request::get('bank_name') == '' ? 0 : Request::get('bank_name')             )))  }}"> Print </a>
    <thead style="background-color: #f2f2f2;">			
		<tr>
			<th>SL</th>															
			<th>Student ID</th> 
            <th>Class</th>												            <th>Payment Name</th>												
			<th>Amount</th> 
			<th>Date</th>    
	</tr>
	</thead>
	<tbody>  
	   <?php $sl=0; ?>	
		<?php $grandTotal = 0; ?>	
	    @if(isset($data['totalIncomeReport']))	
        @if(empty($data['totalIncomeReport']))	
          <tr> <td colspan="6" class="text-danger">No Data Found.</td></tr>		
		@else
		@foreach($data['totalIncomeReport'] as $irt)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->system_generated_student_id }}</td>		 
			<td>{{ $irt->ClassName }}</td>														<td>{{ $irt->student_payment_name }}</td>											
			<td>{{ $irt->payment_amount }}</td>	
			<td><?php echo date("d-m-Y",strtotime($irt->create_time)) ?></td>	
			<?php $grandTotal += (int) $irt->payment_amount; ?>	
		</tr>	       	
		@endforeach
		@endif
		@endif
	
	</tbody>
	<tr><td colspan="15"  style="padding-left:470px" class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	</tr> 
</table>