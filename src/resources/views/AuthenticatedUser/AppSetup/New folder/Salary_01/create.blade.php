@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Salary Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('salary.store')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="salary_name" class="col-sm-2 control-label">Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="salary_name" name="salary_name" placeholder="Salary Name" value="{{ old('salary_name') }}">
                        </div>
                        @if ($errors->has('salary_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('salary_name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="grade_name" class="col-sm-2 control-label">Grade Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="grade_name">
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
                        <label for="salary_amount" class="col-sm-2 control-label">Amount <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="salary_amount" name="salary_amount" placeholder="Salary Amount" value="{{ old('salary_amount') }}">
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
                            <select class="form-control" name="salary_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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