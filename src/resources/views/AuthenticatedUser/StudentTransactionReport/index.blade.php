<?php
$monthArray = array(
    0, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
);
?>

@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')
<div class="row">
    <div class="col-sm-12">
	  <div class="panel panel-default">
        <div class="panel-heading"><strong>Student Transaction Report</strong></div>
           <div class="panel-body">

	<form class="form-horizontal" role="form" id="student_transaction_report_form">
                    {{ csrf_field() }}
		<div class="table-responsive">
        <table class="table table-condensed table-bordered text-uppercase">
          <tbody>
			<input type="hidden" id="class_id" name="class_id" value="{{ $data['userStudent']->class_id }}">
            <input type="hidden" id="group_id" name="group_id" value="{{ $data['userStudent']->stu_group }}">
            <input type="hidden" id="ibv_id" name="ibv_id" value="{{ $data['userStudent']->institute_branch_version_id }}">
			<input type="hidden" id="student_id" name="system_generated_student_id" value="{{ $data['userStudent']-> system_generated_student_id }}">
            <input type="hidden" id="actual_student_id" name="student_id" value="{{ $data['userStudent']->student_id }}">
			
			
                <tr>
                    <td colspan="3">
                        NAME : <strong> {{Auth::user()-> full_name}} </strong>
                    </td>
                    <td>
                        ID : <strong> {{ $data['studentID']->system_generated_student_id }} </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        ROLL : <strong>{{ $data['studentID']->roll_no }}</strong>
                    </td>
                    <td>
                        CLASS : <strong>{{ $data['studentID'] -> ClassName }}</strong>
                    </td>
                    <td>
                        SECTION : <strong>{{ $data['studentID'] -> SectionName }}</strong>
                    </td>
                    <td>
                        GROUP : <strong>{{ $data['studentID'] -> GroupName }}</strong>
                    </td>
                </tr>
				 <tr>
                    <td colspan="3">
                        <div class="form-group">
                            <label for="monthSelect" class="col-sm-2 control-label">Month</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="monthSelect" name="monthSelect">
                                    <option value="" selected="">Select</option>
                                    @foreach($monthArray as $key => $value)
                                    @if($key != 0)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </td>
					<td class="info">  Cash in Hands  : <strong>{{ $data['userStudent']->cash_in_hands }}</strong> </td>
               
                </tr>
				
                <tr>
                    <td colspan="4" id="viewMonthWise_Student_Transaction_table"></td>
                </tr>

        </tbody>
	  </table>
     </div>
   </form>
	</div>
</div>	
</div>	
</div>	
            
	

@endsection