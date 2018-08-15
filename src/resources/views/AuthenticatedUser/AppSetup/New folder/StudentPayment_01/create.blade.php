@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Student Payment Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('studentPayment.store')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="student_payment_name" class="col-sm-2 control-label">Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="student_payment_name" name="student_payment_name" placeholder="Payment Name" value="{{ old('student_payment_name') }}">
                        </div>
                        @if ($errors->has('student_payment_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('student_payment_name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="class_name" class="col-sm-2 control-label">Class <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="class_name" id="class_name">
                                <option value="">----- Select -----</option>
                                @if(isset($data['studentClasses']))
                                @foreach($data['studentClasses'] as $cl)
                                <option value="{{ $cl->id }}">{{ $cl->ClassName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('class_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('class_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="group_name" class="col-sm-2 control-label">Group <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="group_name" id="group_name">
                                <option value="">----- Select -----</option>
                                @if(isset($data['studentGroups']))
                                @foreach($data['studentGroups'] as $sg)
                                <option value="{{ $sg->id }}">{{ $sg->GroupName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('group_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('group_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="fees_type" class="col-sm-2 control-label">Fees Type <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="fees_type" id="fees_type">
                                <option value="">----- Select -----</option>
                                @if(isset($data['feesTypes']))
                                @foreach($data['feesTypes'] as $ft)
                                <option value="{{ $ft->fees_type_id }}">{{ $ft->fees_type_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('fees_type'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('fees_type') }}</strong>
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