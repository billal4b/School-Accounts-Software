@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Update Salary Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('salary.update', array('id' => $data['salarySubHeadList']->salary_sub_head_id))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    <div class="form-group form-group-sm">
                        <label for="salary_sub_head_name" class="col-sm-2 control-label">Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="salary_sub_head_name" name="salary_sub_head_name" placeholder="Grade Name" value="{{ $data['salarySubHeadList']->salary_sub_head_name }}">
                        </div>
                        @if ($errors->has('salary_sub_head_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('salary_sub_head_name') }}</strong>
                        </span>
                        @endif
                    </div>
					<div class="form-group form-group-sm">
                        <label for="grade_name" class="col-sm-2 control-label">Grade Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
						 <select class="form-control" name="grade_name" id="grade_name">
                                <option value="">----- Select -----</option>
                                @if(isset($data['employeeGradeList']))
                                @foreach($data['employeeGradeList'] as $egl)
                                <option value="{{ $egl->grade_id }}">{{ $egl->grade_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('grade_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('grade_name') }}</strong>
                        </span>
                        @endif
                    </div>
	
					<div class="form-group form-group-sm">
                        <label for="salary_amount" class="col-sm-2 control-label">Amount  <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="salary_amount" name="salary_amount" placeholder="Grade Name" value="{{ $data['salarySubHeadList']->salary_amount }}">
                        </div>
                        @if ($errors->has('salary_amount'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('salary_amount') }}</strong>
                        </span>
                        @endif
                    </div>

                    
                    <div class="form-group form-group-sm">
                        <label for="salary_status" class="col-sm-2 control-label">Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="salary_status" id="salary_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                            <script type="text/javascript">
                                document.getElementById('grade_name').value = '{{ $data['salarySubHeadList']->grade_id }}';
                                document.getElementById('salary_status').value = '{{ $data['salarySubHeadList']->is_active }}';
                            </script>
                        </div>
                        @if ($errors->has('salary_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('salary_status') }}</strong>
                        </span>
                        @endif
                    </div>

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