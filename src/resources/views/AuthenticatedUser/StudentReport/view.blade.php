<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>

<table class="table table-condensed table-bordered">
@if(Auth::user()->role_id == 9)
	<thead class='header'>
		<tr>
			<th>SL</th>
			<th>Receipt No</th>
			<th>Student ID</th>
			<th>Amount</th>                      			             
			<th>Payment Date</th>
			<th>Status</th>
			@if(Auth::user()->bank_user_rank == 1 )
			<th>Action</th>
		   @endif
		</tr>
	</thead>
	<tbody>   
	
		<?php $sl=0; ?>
		
		<?php $grandTotal = 0; ?>
		@if(isset($data['paymentReport']))
		@foreach($data['paymentReport'] as $egl)
		<tr>
		    
			<td>{{ ++$sl }}</td>
			<td>{{ $egl->received_student_payment_id }}</td>
			<td>{{ $egl->system_generated_student_id }}</td>
			<td>{{ $egl->received_amount_by_bank }}</td>			
			<td><?php echo date("d-m-Y",strtotime($egl->received_time)) ?></td>
		    <td> <span class="label label-{{ $egl->confirm_by_bank_admin == 1 ? 'success' : 'danger' }}">{{ $egl->confirm_by_bank_admin == 1 ? 'Confirm' : 'Not Confirm' }}</span> </td>
			
			@if(Auth::user()->bank_user_rank == 1 && $egl->confirm_by_bank_admin == 0)
			<td>
			<a class="btn btn-success btn-sm confirm-btn" id="{{ $egl->received_student_payment_id }}"><i class="fa fa-okay"></i>&nbsp;Confirm</a>
			
			<a class="btn btn-primary btn-sm" href="{{ url(route('studentReport::editPaymentAmount', array('received_student_payment_id' => $egl-> received_student_payment_id))) }}"> <i class="fa fa-pencil-square-o"></i> &nbsp;Edit </a>
			</td>
			@endif
			<?php $grandTotal += (int) $egl->received_amount_by_bank; ?>						
		</tr>
		@endforeach
		@endif 
		
	</tbody>
	 <tr><td colspan="15" align="Center" style="padding-left:30px" class="text-uppercase">Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	 </tr>
        <a class="btn btn-lg  btn-primary fa fa-print" target="_blank" style="cursor:pointer;" href="{{ url(route('studentReport::printReport', array('fromDate' => Request::get('from_date'), 'toDate' => Request::get('to_date')))) }}"> Print </a>
		
	@elseif(Auth::user()->role_id == 8)
	  <thead>
		<tr>
			<th>SL</th>
			<th>Receipt No</th>
			<th>Student ID</th>
			<th>Bank Name</th>
			<th>Branch Name</th>
			<th>A/C </th>
			<th>Amount</th>                      			             
			<th>Date</th>                      
			<th>Status</th>                      
		</tr>
	</thead>
	<tbody>   
	
		<?php $sl=0; ?>
		
		<?php $grandTotal = 0; ?>
		@if(isset($data['paymentReport']))
		@foreach($data['paymentReport'] as $egl)
	    
		@if($egl->confirm_by_bank_admin == 1)
		<tr>
		    
			<td>{{ ++$sl }}</td>
			<td>{{ $egl->received_student_payment_id }}</td>
			<td>{{ $egl->system_generated_student_id }}</td>
			<td>{{ $egl->bank_name }}</td>
			<td>{{ $egl->branch_name }}</td>
			<td>{{ $egl->account_no }}</td>
			<td>{{ $egl->received_amount_by_bank }}</td>
			<td><?php echo date("d-m-Y",strtotime($egl->create_time)) ?></td>
			<td><span class="label label-{{ $egl->confirm_by_school_user_id ==  Null && $egl->confirm_time ==  Null ? 'danger ' : 'success' }}">{{ $egl->confirm_by_school_user_id ==  Null && $egl->confirm_time ==  Null ? 'Not Confirm' : 'Confirm' }}</span></td>
		
			<?php $grandTotal += (int) $egl->received_amount_by_bank; ?>						
		</tr>
		
		@endif
		@endforeach
		@endif
	</tbody>
	
	 <tr><td colspan="15" align="Center"  style="padding-left: 380px" class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	 </tr>
	
	@endif 
 </table>
