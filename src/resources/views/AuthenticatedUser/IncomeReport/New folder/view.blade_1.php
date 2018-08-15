<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>

<table class="table table-condensed table-bordered">
	<thead class='header'>
		<tr>
		
			<th>SL</th>
			<th>Class</th>					
								
			<th>Amount</th> 

		</tr>
	</thead>
	<tbody>   
	
	    <?php $sl=0; ?>	
		<?php $grandTotal = 0; ?>
		
		@if(isset($data['totalIncomeReport']))
		@foreach($data['totalIncomeReport'] as $irt)
		<tr>
		   @if($irt->confirm_by_school_user_id == 1)
			   
			<td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->ClassName }}</td>						
										
			<td>{{ $irt->received_amount_by_bank }}</td>			
			
			<?php $grandTotal += (int) $irt->received_amount_by_bank; ?>	
			@endif 
		</tr>
		
		@endforeach
		@endif 
	
	</tbody>
	<tr><td colspan="15"  style="padding-left:350px" class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	</tr>
	
 </table>