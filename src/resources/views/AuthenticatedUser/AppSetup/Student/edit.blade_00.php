@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Student Details </strong></div>
            <div class="panel-body">

                @if (session()->has('errorMessage'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> {{ session()->pull('errorMessage') }}
                </div>
                @endif
                @if (session()->has('successMessage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> {{ session()->pull('successMessage') }}
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('student.update', array('id' => $data['stdDetails']->student_id))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    <div class="form-group form-group-sm">
                        <label for="student_name" class="col-sm-2 control-label">Student Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Student Name" value="{{ $data['stdDetails']->student_name }}">
                        </div>
                    </div>
                    <input type="hidden" name="system_generated_student_id" value="{{ $data['stdDetails']->system_generated_student_id }}">

                    <div class="form-group form-group-sm">
                        <label for="year_of_admission" class="col-sm-2 control-label">Admission Year <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-3">
                            <select class="form-control" id="year_of_admission" name="year_of_admission">
                                <option value="">---Select---</option>
                                @if(isset($data['years']))
                                @foreach($data['years'] as $class)
                                <option value="{{ $class->year_id }}">{{ $class->year }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                         <label for="branch_and_version" class="col-sm-3 control-label">Branch And Version <sup>
						   <i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                         
						<select id="branch_and_version" name="branch_and_version" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['secInstitutes']))
                                @foreach($data['secInstitutes'] as $si)
                                   <option value="{{ $si->institute_branch_version_id }}">
								   {{ $si->school_branch_name }}, {{ $si->school_version_name }} Version
								</option>
								
								
                                @endforeach
                                @endif
                        </select>														
                        </div> 
					</div>	
					<div class="form-group form-group-sm">	
												
                        <label for="class_id" class="col-sm-2 control-label">Class <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-3">
                            <select class="form-control" id="class_id" name="class_id">
                                <option value="">---Select---</option>
                                @if(isset($data['studentClasses']))
                                @foreach($data['studentClasses'] as $class)
                                <option value="{{ $class->id }}">{{ $class->ClassName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
						
                        <label for="section_name" class="col-sm-3 control-label">Section <sup><i class="fa fa-asterisk"> </i>  </sup></label>
                        <div class="col-sm-4">
                             <select id="section_name" name="section_name" class="form-control">
                                <option value="">--- Select ---</option>
                               
                        </select>
                        </div>   
					</div>	
                    

                    <div class="form-group form-group-sm">
					   							
                        <label for="group_name" class="col-sm-2 control-label">Group <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-3">
                            <select class="form-control" name="group_name" id="group_name">
                                <option value="">----- Select -----</option>
                                @if(isset($data['studentGroups']))
                                @foreach($data['studentGroups'] as $sg)
							      <option value="{{ $sg->id }}">{{ $sg->GroupName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
						<label for="system_generated_student_id" class="col-sm-3 control-label">Student ID <sup>
						<i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" placeholder="Student ID"  id="system_generated_student_id" name="system_generated_student_id" value="{{  $data['stdDetails']->system_generated_student_id }}"readonly/>
                        </div>						
					 </div>	
					 					 
					 <div class="form-group form-group-sm">
						<label for="roll_no" class="col-sm-2 control-label">Roll No <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-3">
                           <input type="text" class="form-control" id="roll_no" name="roll_no" placeholder="Roll No" value="{{  $data['stdDetails']->roll_no }}" />
                        </div>	
                       
                        <label for="contact_for_sms" class="col-sm-3 control-label">Contact for SMS <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <div class=" input-group">
                            <span class="input-group-addon" id="basic-addon1">8801</span>
                            <input type="text" class="form-control" id="contact_for_sms" name="contact_for_sms" placeholder="Contact for SMS" value="{{ substr($data['stdDetails']->contact_for_sms, 4) }}" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>


<!--                    <div class="form-group form-group-sm">
                        <label for="father_name" class="col-sm-2 control-label">Father's Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Father Name" value="{{ $data['stdDetails']->father_name }}">
                        </div>

                        <label for="father_mobile" class="col-sm-2 control-label">Father's Mobile <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <div class=" input-group">
                            <span class="input-group-addon" id="basic-addon2">8801</span>
                            <input type="text" class="form-control" id="father_mobile" name="father_mobile" placeholder="Father Mobile" value="{{ substr($data['stdDetails']->father_mobile, 4) }}" aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>


                    <div class="form-group form-group-sm">
                        <label for="mother_name" class="col-sm-2 control-label">Mother's Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="Mother Name" value="{{ $data['stdDetails']->mother_name }}">
                        </div>

                        <label for="mother_mobile" class="col-sm-2 control-label">Mother's Mobile <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <div class=" input-group">
                            <span class="input-group-addon" id="basic-addon3">8801</span>
                            <input type="text" class="form-control" id="mother_mobile" name="mother_mobile" placeholder="Mother Mobile" value="{{ substr($data['stdDetails']->mother_mobile, 4) }}" aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>-->


                    <div class="form-group form-group-sm">
					
					    <label for="gender" class="col-sm-2 control-label">Gender <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-3">
                            <select class="form-control" id="gender" name="gender">
                                <option value="">---Select---</option>
                                @if(isset($data['genders']))
                                @foreach($data['genders'] as $class)
                                <option value="{{ $class->gender_id }}" >{{ $class->gender }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <label for="status" class="col-sm-3 control-label">Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="status" id="status">
                                <option value="">----- Select -----</option>
                                <option value="1">Regular</option>
                                <option value="2">Irregular</option>
                            </select>
                        </div>
                    </div>
                    
                    <script type="text/javascript">
						document.getElementById('year_of_admission').value = '{{ $data['stdDetails'] ->year_of_admission }}';
						document.getElementById('branch_and_version').value= '{{ $data['stdDetails']->                institute_branch_version_id }}';
						document.getElementById('class_id').value          = '{{ $data['stdDetails']->class_id }}';
						document.getElementById('gender').value            = '{{ $data['stdDetails']->gender }}';
						document.getElementById('status').value            = '{{ $data['stdDetails']->status }}';
						document.getElementById('group_name').value        = '{{ $data['stdDetails']->stu_group }}';
						//document.getElementById('section_name').value      = '{{ $data['stdDetails']->section_id }}';
						document.getElementById('roll_no').value           = '{{ $data['stdDetails']->roll_no }}';
                        var section_id = '{{ $data['stdDetails']->section_id }}';
					</script>

                    <div class="form-group form-group-sm">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection