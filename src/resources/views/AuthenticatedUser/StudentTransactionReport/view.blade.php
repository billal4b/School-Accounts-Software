
<table class="table table-striped table-bordered">
	<thead style="background-color: #f2f2f2;">			
		<tr>
			<th>SL</th>																										
            <th>Payment Name</th>												
			<th>Amount</th> 
			<th>Date</th>    
			<th>Status</th>    
		</tr>
	</thead>
	<tbody>  
	   <?php $sl=0; ?>	
		
	    @if(isset($data['studentTransaction']))
		@foreach($data['studentTransaction'] as $irt)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           												
			<td>{{ $irt->student_payment_name }}</td>											
			<td>{{ $irt->payment_amount }}</td>	
			<td><?php echo date("d-m-Y",strtotime($irt->create_time)) ?></td>
			<td> <span class="label label-{{ $irt->pay_status == 1 ? 'success' : 'danger' }}">{{ $irt->pay_status == 1 ? 'Confirm' : 'Not Confirm' }}</span> </td>
			
			
		</tr>	       	
		@endforeach
		@endif 
	</tbody>

 </table>