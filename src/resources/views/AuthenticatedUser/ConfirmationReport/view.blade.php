<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>

<table class="table table-striped table-bordered">
	  <thead style="background-color: #f2f2f2;">
		<tr>
			<th>SL</th>
			<th>Receipt No</th>
			<th>Student ID</th>
			<th>Bank Name</th>
			<th>Branch Name</th>
			<th>A/C </th>
			<th>Amount</th>                      			             
			<th>Date</th>                      
			                 
		</tr>
	</thead>
	<tbody>   
	
		<?php $sl=0; ?>
		
		<?php $grandTotal = 0; ?>
		@if(isset($data['paymentConfirmationReport']))
		@foreach($data['paymentConfirmationReport'] as $egl)
		<tr>
		    
			<td>{{ ++$sl }}</td>
			<td>{{ $egl->student_id }}</td>
			<td>{{ $egl->system_generated_student_id }}</td>
			<td>{{ $egl->bank_name }}</td>
			<td>{{ $egl->branch_name }}</td>
			<td>{{ $egl->account_no }}</td>
			<td>{{ $egl->received_amount_by_bank }}</td>
			<td><?php echo date("d-m-Y",strtotime($egl->create_time)) ?></td>
		
			
			<?php $grandTotal += (int) $egl->received_amount_by_bank; ?>						
		</tr>
		@endforeach
		@endif
	</tbody>
	
	 <tr><td colspan="15" align="Center"  style="padding-left: 380px" class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	 </tr>
	
 </table>
