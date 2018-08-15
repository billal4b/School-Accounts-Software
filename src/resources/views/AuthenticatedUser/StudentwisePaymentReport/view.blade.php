<?php // echo '<pre>';print_r($data['oneStudent']);echo '</pre>';exit();  ?>
<?php ?>

<table class="table table-striped table-bordered">


    <thead style="background-color: #f2f2f2;">
        <tr>
            <th>SL</th>															
            <th>Student ID</th> 
            <th>Name</th> 
            <th>Roll</th> 
            <th>Total Payment</th> 
            <th>Cash</th> 
            <th>Contact</th> 
        </tr>
    </thead>
    <tbody>  
        <?php $sl = 0;
        $students = array(); ?>	

        @if(isset($data['StudentWisePayment']))
        @foreach($data['StudentWisePayment'] as $irt)
        <?php $students[] = $irt->student_id; ?>
        <tr>		
            <td>{{ ++$sl }}</td>	           		
            <td>{{ $irt->system_generated_student_id }}</td>		 
            <td>{{ $irt->student_name }}</td>		 
            <td>{{ $irt->roll_no }}</td>	
            <td>{{ $irt->pa }}</td>	
            <td>{{ $irt->cash_in_hands }}</td>	
            <td>{{ $irt->contact_for_sms }}</td>	

        </tr>	        
        @endforeach
        @endif 

        <?php
        if(count($data['StudentWisePayment'])>1) {
            foreach ($data['students'] as $s) {
                if (!in_array($s->student_id, $students)) {
                    ?>
                    <tr class="danger">		
                        <td>{{ ++$sl }}</td>	           		
                        <td>{{ $s->system_generated_student_id }}</td>		 
                        <td>{{ $s->student_name }}</td>		 
                        <td>{{ $s->roll_no }}</td>	
                        <td>0</td>	
                        <td>0</td>	
                        <td>{{ $s->contact_for_sms }}</td>	

                    </tr>	
                    <?php
                }
            }
        }else if(count($data['StudentWisePayment'])<1){
            if(isset($data['oneStudent'])){
            $st = DB::table('tbl_students')
                                        ->select('student_id', 'system_generated_student_id', 'student_name', 'roll_no', 'cash_in_hands', 'contact_for_sms')
//                                        ->where('class_id', $class_name)
//                                        ->where('stu_group', $group_name)
//                                        ->where('section_id', $section_name)
//                                        ->where('institute_branch_version_id', $branch_and_version)
                                        ->where('status', 1)
                                        ->where('student_id', $data['oneStudent'])
                                        ->first();
            ?>
                    <tr class="danger">		
                        <td>{{ ++$sl }}</td>	           		
                        <td>{{ $st->system_generated_student_id }}</td>		 
                        <td>{{ $st->student_name }}</td>		 
                        <td>{{ $st->roll_no }}</td>	
                        <td>0</td>	
                        <td>0</td>	
                        <td>{{ $st->contact_for_sms }}</td>	

                    </tr>
                    <?php
            }
        }
        ?>
    </tbody>
</table>




