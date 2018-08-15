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
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Student Name" value="{{ $data['stdDetails']->student_name }}">
                        </div>
                    </div>
                    <input type="hidden" name="system_generated_student_id" value="{{ $data['stdDetails']->system_generated_student_id }}">

                    <div class="form-group form-group-sm">
                        <label for="year_of_admission" class="col-sm-2 control-label">Year of Admission <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" id="year_of_admission" name="year_of_admission">
                                <option value="">---Select---</option>
                                @if(isset($data['years']))
                                @foreach($data['years'] as $class)
                                <option value="{{ $class->year_id }}">{{ $class->year }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <label for="class_id" class="col-sm-2 control-label">Class Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" id="class_id" name="class_id">
                                <option value="">---Select---</option>
                                @if(isset($data['studentClasses']))
                                @foreach($data['studentClasses'] as $class)
                                <option value="{{ $class->id }}">{{ $class->ClassName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div> 
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="group_name" class="col-sm-2 control-label">Group <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="group_name" id="group_name">
                                <option value="">----- Select -----</option>
                                @if(isset($data['studentGroups']))
                                @foreach($data['studentGroups'] as $sg)
                                <option value="{{ $sg->id }}">{{ $sg->GroupName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>


                    <div class="form-group form-group-sm">
                        <label for="gender" class="col-sm-2 control-label">Gender <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" id="gender" name="gender">
                                <option value="">---Select---</option>
                                @if(isset($data['genders']))
                                @foreach($data['genders'] as $class)
                                <option value="{{ $class->gender_id }}">{{ $class->gender }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <label for="contact_for_sms" class="col-sm-2 control-label">Contact for SMS <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contact_for_sms" name="contact_for_sms" placeholder="Contact for SMS" value="{{ $data['stdDetails']->contact_for_sms }}">
                        </div>
                    </div>


                    <div class="form-group form-group-sm">
                        <label for="father_name" class="col-sm-2 control-label">Father Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Father Name" value="{{ $data['stdDetails']->father_name }}">
                        </div>

                        <label for="father_mobile" class="col-sm-2 control-label">Father Mobile <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="father_mobile" name="father_mobile" placeholder="Father Mobile" value="{{ $data['stdDetails']->father_mobile }}">
                        </div>
                    </div>


                    <div class="form-group form-group-sm">
                        <label for="mother_name" class="col-sm-2 control-label">Mother Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="Mother Name" value="{{ $data['stdDetails']->mother_name }}">
                        </div>

                        <label for="mother_mobile" class="col-sm-2 control-label">Mother Mobile <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mother_mobile" name="mother_mobile" placeholder="Mother Mobile" value="{{ $data['stdDetails']->mother_mobile }}">
                        </div>
                    </div>


                    <div class="form-group form-group-sm">
                        <label for="branch_and_version" class="col-sm-3 control-label">Branch And Version <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            @if(isset($data['secInstitutes']))
                            @foreach($data['secInstitutes'] as $si)
                            <div class="radio">
                                <label>
                                    <input name="branch_and_version" type="radio" value="{{ $si->institute_branch_version_id }}" {{ $si->institute_branch_version_id == $data['stdDetails']->institute_branch_version_id ? 'checked' : '' }}>
                                    {{ $si->school_branch_name }}, {{ $si->school_version_name }} Version
                                </label>
                            </div>
                            @endforeach
                            @endif
                        </div>                     
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="status" class="col-sm-2 control-label">Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="status">
                                <option value="">----- Select -----</option>
                                <option value="1">Regular</option>
                                <option value="2">Irregular</option>
                            </select>
                        </div>
                    </div>
                    
                    <script type="text/javascript">
                                document.getElementById('year_of_admission').value = '{{ $data['stdDetails']->year_of_admission }}';
                                document.getElementById('class_id').value = '{{ $data['stdDetails']->class_id }}';
                                document.getElementById('gender').value = '{{ $data['stdDetails']->gender }}';
                                document.getElementById('status').value = '{{ $data['stdDetails']->status }}';
                                document.getElementById('group_name').value = '{{ $data['stdDetails']->stu_group }}';
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