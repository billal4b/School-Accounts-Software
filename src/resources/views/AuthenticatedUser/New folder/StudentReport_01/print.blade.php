<?php //print_r($data['paymentReport']); exit(); ?>
<table width="100%" border="1" align='Center'>
	<thead class='header'>
		<tr>
			<th>SL</th>
			<th>Receipt No</th>
			<th>Student ID</th>
			<th>Amount</th>                      			             
			<th>Payment Date</th>
		</tr>
	</thead>
	<tbody>   
	
		<?php $sl=0; ?>
		
		<?php $grandTotal = 0; ?>
		<?php 
		if (isset($data['paymentReport'])){
		  foreach($data['paymentReport'] as $egl){
		  ?>
		<tr>
		    
			<td><?php echo ++$sl ?></td>
			<td><?php  echo $egl->student_id ?></td>
			<td><?php  echo $egl->system_generated_student_id ?></td>
			<td><?php  echo $egl->received_amount_by_bank ?></td>
			
			<td><?php echo date("d-m-Y",strtotime($egl->create_time)) ?></td>
		
			<?php $grandTotal += (int) $egl->received_amount_by_bank; ?>						
		</tr>
		<?php
		  }
		}
		?>
		
	</tbody>
	 <tr><td colspan="15" align="Center" style="padding-left:30px" class="text-uppercase">Grand Total : <strong>
	    <?php  echo $grandTotal; ?> </strong></td>
	 </tr>
       
	
 </table>