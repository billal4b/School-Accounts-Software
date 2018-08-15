<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?>

<table class="table table-striped table-bordered">
	<thead style="background-color: #f2f2f2;">			
		<tr>
			<th>SL</th>															
			<th>Invoice No</th> 
           	<th>Sub Head</th> 			          																						
			<th>Amount</th> 
			<th>Date</th> 
	    
            <th>Check No</th>		
       	
		</tr>
	</thead>
	<tbody>  
	   <?php $sl=0; ?>	
		<?php $grandTotal = 0; ?>
		
	    @if(isset($data['ExpenseReport']))
		@foreach($data['ExpenseReport'] as $expr)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $expr->invoice_no }}</td>		 
			<td>{{ $expr->sub_head_name }}</td>																								
			<td>{{ $expr->sub_total }}</td>	
			<td><?php echo date("d-m-Y",strtotime($expr->expense_date)) ?></td>	
		
			<td>{{ $expr->check_no }}</td>	
		
			
			<?php $grandTotal += (int) $expr->sub_total; ?>	
		</tr>	       	
		@endforeach
		@endif 
	</tbody>
	<tr><td colspan="15"  style="padding-left:330px" class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	</tr>
 </table>