<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>

<table class="table table-striped table-bordered">
 
	<thead style='background-color: #f2f2f2;'>		
		
		<tr>
			<th>SL</th>															
			<th>Student ID</th> 		 
			<th>Bank</th>	
			<th>Branch</th>									
			<th>A/C</th>									
			<th>Amount</th> 
			<th>Date</th>  
	     	
			
	    
		</tr>
	</thead>
	<tbody>  
	   <?php $sl=0; ?>	
		<?php $grandTotal = 0; ?>
		
	    @if(isset($data['totalIncomeReport']))
		@foreach($data['totalIncomeReport'] as $irt)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->system_generated_student_id }}</td>			 
			<td>{{ $irt->bank_name }}</td>			
			<td>{{ $irt->branch_name }}</td>					
			<td>{{ $irt->account_no }}</td>					
			<td>{{ $irt->received_amount_by_bank }}</td>	
			<td><?php echo date("d-m-Y",strtotime($irt->create_time)) ?></td>	
			
			<?php $grandTotal += (int) $irt->received_amount_by_bank; ?>	
		</tr>	
         	
		@endforeach
		@endif 
	</tbody>
	<tr><td colspan="15"  style="padding-left:600px" class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	</tr>


 </table>