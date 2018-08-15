<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>

<table class="table table-condensed table-bordered">
 
	<thead class='header'>
	    <?php $sl=0; ?>	
		<?php $grandTotal = 0; ?>
		
		@if(isset($data['totalIncomeReport']))
		@foreach($data['totalIncomeReport'] as $irt)
		<tr>
			<th>SL</th>															
			<th>Name</th> 
			<th>Class</th>	
			<th>Bank</th>	
			<th>Branch</th>									
			<th>Contact</th>									
			<th>Amount</th> 
			<th>Date</th>  
		</tr>
	</thead>
	<tbody>   	
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->student_name }}</td>	
			<td>{{ $irt->ClassName }}</td>	
			<td>{{ $irt->bank_name }}</td>
			<td>{{ $irt->branch_name }}</td>		
			<td>{{ $irt->contact_for_sms }}</td>
			<td>{{ $irt->received_amount_by_bank }}</td>	
			<td><?php echo date("d-m-Y",strtotime($irt->create_time)) ?></td>	
           					
			<?php $grandTotal += (int) $irt->received_amount_by_bank; ?>	
		</tr>		
		@endforeach
		@endif 
	</tbody>
	<tr><td colspan="15"  style="padding-left:350px" class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	</tr>

 </table>