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
                
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('studentPayment.store')) }}">
                    {{ csrf_field() }}

		    <div class="form-group form-group-sm">
                        <label for="student_payment_name" class="col-sm-2 control-label"> Payment Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="student_payment_name" name="student_payment_name" placeholder="Payment Type" value="{{ old('student_payment_name') }}">
                        </div>
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
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="payment_month" class="col-sm-2 control-label">Month </label>
                        <div class="col-sm-6">
                            <select class="form-control" id="payment_month" name="payment_month">
                                <option value="1" selected="selected">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="payment_amount" class="col-sm-2 control-label">Amount <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="payment_amount" name="payment_amount" placeholder="Amount" value="{{ old('payment_amount') }}">
                        </div>
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="branch_and_version" class="col-sm-2 control-label">Branch And Version <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            @if(isset($data['secInstitutes']))
                            @foreach($data['secInstitutes'] as $si)
                            <div class="checkbox">
                                <label>
                                    <input name="branch_and_version[]" type="checkbox" value="{{ $si->institute_branch_version_id }}">
                                    {{ $si->school_branch_name }}, {{ $si->school_version_name }} Version
                                </label>
                            </div>
                            @endforeach
                            @endif
                        </div>                     
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="student_payment_status" class="col-sm-2 control-label">Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="student_payment_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
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