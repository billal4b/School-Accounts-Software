@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong> Salary Sheet</strong></div>
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





                <form class="form-horizontal" role="form" onsubmit="return false;">

                    {{ csrf_field() }}
                    <div class="form-group form-group-sm">

                        <label for="month" class="col-sm-3 control-label">Month <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-3">
                            <select class="form-control" name="month" id="month">
                                <option value="">Select</option>
                                <option value="1">January</option>
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
                        <label for="month" class="col-sm-3 control-label">Role <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-3">
                            <select class="form-control" name="user_role" id="user_role" multiple="multiple" size="16">
                                <option value="">Select</option>

                                @if(isset($data['user_roles']))
                                @foreach($data['user_roles'] as $ur)
                                <option value="{{ $ur->role_id }}">{{ $ur->role_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group form-group-sm">					
						  <label for="branch_version" class="col-sm-3 control-label">Branch And Version <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4" >
                            <select id="branch_version" name="branch_version" class="form-control"  multiple="multiple" size=16 id="branch_version">
                                <option value="">----- Select -----</option>
                                @if(isset($data['secInstitutes']))
                                @foreach($data['secInstitutes'] as $si)
                                   <option value="{{ $si->institute_branch_version_id.'_'.$si->school_version_name{0} }}">
								   {{ $si->school_branch_name }}, {{ $si->school_version_name }} Version
								</option>
                                @endforeach
                                @endif
                        </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-primary btn-sm btn-block" id="processSalarySheet"><i class="fa fa-spinner"></i> Process Salary Sheet</button>
                        </div>
                        
                        <div class="col-sm-2" id="wait" style="display: none;">

                            <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>

                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-success btn-sm btn-block"  id="viewSalarySheet"><i class="fa fa-list-alt"></i> View Salary Sheet</button>
                        </div>
                    </div>


                </form>

                <div id="salarySheetInfo"></div>

            </div>
        </div>
    </div>
</div>


@endsection