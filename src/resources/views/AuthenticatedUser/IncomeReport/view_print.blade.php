<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?><style>    table {        border-collapse: collapse;        width: 100%;    }    thead, td {        text-align: left;   }    tr:nth-child(even){background-color: #f2f2f2}    thead {        background-color: #4CAF50;        color: white;    }</style>

<?php
$monthArray = array(
    0, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
);
?>

<table class="table table-striped table-bordered table-condensed" style="font-size: 12px;"
			 
	<thead style="background-color: #f2f2f2;">			
		<tr>
  		    <th>SL</th>															
			<th>Student ID</th> 
			<th>Receipt No.</th> 
			<th>Book Sl.</th>
			<th>Class</th>			
			<th>Group</th>			
			<th>Section</th>			
			<th>Bank</th>										
                        <!--<th>Account No.</th>-->										
			<th>Amount</th> 
			 
			<th>Head</th> 
			<th>Month</th> 
			<th>Date</th>    
		</tr>
	</thead>
	<tbody>  
	   <?php $sl=0; ?>	
		<?php $grandTotal = 0; ?>
	    @if(isset($data['IncomeReportPrint']))
            <?php //echo '<pre>';print_r($data['IncomeReportPrint']);exit(); ?>
		@foreach($data['IncomeReportPrint'] as $irt)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->system_generated_student_id }}</td>		 
			<td>{{ $irt->received_student_payment_id }}</td>
            <td>{{ $irt->book_sl_no }}</td>	
			<td>{{ $irt->ClassName }}</td>							
			<td>{{ $irt->GroupName }}</td>							
			<td>{{ $irt->SectionName }}</td>							
			<td>{{ $irt->bank_name }}</td>								
			<td>{{ $irt->payment_amount }}</td>				
			<td>{{ $irt->student_payment_name }}</td>	
			<td><?php echo $monthArray[$irt->month] ?></td>	
			<td><?php echo date("d-m-Y",strtotime($irt->received_time)) ?></td>	
			<?php $grandTotal += (int) $irt->payment_amount; ?>	
		</tr>	       	
		@endforeach
		@endif 
	</tbody>
	<tr><td colspan="15"  style="padding-left:510px" class="text-uppercase"> Grand Total : <strong>

	    <?php  echo $grandTotal; ?> </strong></td>

	</tr>

 </table>
