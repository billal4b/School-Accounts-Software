<?php //echo '<pre>';print_r(Request::get('from_date'));echo '</pre>';exit(); ?><style>    table {        border-collapse: collapse;        width: 100%;    }    thead, td {        text-align: left;        padding: 8px;    }    tr:nth-child(even){background-color: #f2f2f2}    thead {        background-color: #4CAF50;        color: white;    }</style>
<table class="table table-striped table-bordered">
	<thead>			
		<tr>
  		    <th>SL</th>															
			<th>Student ID</th> 
            <th>Class</th>			
			<th>Bank</th>											
			<th>Amount</th> 
			<th>Date</th>    
		</tr>
	</thead>
	<tbody>  
	   <?php $sl=0; ?>	
		<?php $grandTotal = 0; ?>
	    @if(isset($data['IncomeReportPrint']))
		@foreach($data['IncomeReportPrint'] as $irt)
	    <tr>		
	        <td>{{ ++$sl }}</td>	           		
			<td>{{ $irt->system_generated_student_id }}</td>		 
			<td>{{ $irt->ClassName }}</td>							
			<td>{{ $irt->bank_name }}</td>							
			<td>{{ $irt->received_amount_by_bank }}</td>	
			<td><?php echo date("d-m-Y",strtotime($irt->create_time)) ?></td>	
			<?php $grandTotal += (int) $irt->received_amount_by_bank; ?>	
		</tr>	       	
		@endforeach
		@endif 
	</tbody> 
	<tr><td colspan="15"  style="padding-left:510px; class="text-uppercase"> Grand Total : <strong>
	    <?php  echo $grandTotal; ?></strong></td>
	</tr>
 </table>