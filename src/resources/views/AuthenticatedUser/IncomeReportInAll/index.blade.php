@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')


<div class="row">
    <div class="col-sm-12">
	    <div class="panel panel-default">
            <div class="panel-heading"><strong>Income Report </strong></div>
			
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

				
				<form class="form-horizontal" role="form" id='income_report_in_all_form'>
                    {{ csrf_field() }}
					
			    <div class="form-group form-group-sm">
				   <div>
					<label for="from_date" class="col-sm-3 control-label"> Date From <sup><i class="fa fa-asterisk"></i></sup> </label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="from_date" name="from_date" placeholder="Date From"  readonly="readonly" required="required"/>
					</div>
					  @if ($errors->has('from_date'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('from_date') }}</strong>
                        </span>
                      @endif
                    </div>
                    <div>
					
					<label for="to_date" class="col-sm-3 control-label"> Date To <sup><i class="fa fa-asterisk"> </i></sup></label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="to_date" name="to_date" placeholder="Date To" value="{{ old('to_date') }}" readonly="readonly" required="required"/>
					</div>
					  @if ($errors->has('to_date'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('to_date') }}</strong>
                        </span>
                      @endif
					</div>
                </div>
				<div class="form-group form-group-sm">
										
                </div>
				<div class="form-group form-group-sm">
				    <label for="branch_version_name" class="col-sm-3 control-label">Branch </label>
					<div class="col-sm-3">
					    <select id="branch_version_name" name="branch_version_name" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['secInstitutes']))
                                @foreach($data['secInstitutes'] as $hds)
                                <option value="{{ $hds->institute_branch_version_id }}">
								    {{ $hds->school_branch_name }},{{ $hds->school_version_name }} 
								</option>
                                @endforeach
                                @endif
                        </select>
					</div>	
					
					<label for="class_name" class="col-sm-3 control-label">Class Name</label>
					<div class="col-sm-3">
					    <select id="class_name" name="class_name" class="form-control">
                                <option value="">--- Select ---</option>
                                @if(isset($data['classWise']))
                                @foreach($data['classWise'] as $hds)
                                <option value="{{ $hds->id }}">{{ $hds->ClassName }}</option>
                                @endforeach 
                                @endif
                        </select>
					</div>
                </div>
				<div class="form-group form-group-sm">
				   
					<label for="group_name" class="col-sm-3 control-label">Group Name </label>
					<div class="col-sm-3">
					    <select id="group_name" name="group_name" class="form-control">
                               <option value="">--- Select ---</option>
                                @if(isset($data['groupWise']))
                                @foreach($data['groupWise'] as $hds)
                                <option value="{{ $hds->id }}">{{ $hds->GroupName }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>
                    <label for="student_id" class="col-sm-3 control-label">Student ID </label>
                    <div class="col-sm-3">
                        <select id="student_id" name="student_id" class="form-control">
                            <option value="">--- Select ---</option>
                            
                        </select>
                    </div>

                </div>
				<div class="form-group form-group-sm">
				<label for="bank_name" class="col-sm-3 control-label">Bank Name</label>
					<div class="col-sm-3">
					    <select id="bank_name" name="bank_name" class="form-control">
                               <option value="">--- Select ---</option>
                                @if(isset($data['bankWise']))
                                @foreach($data['bankWise'] as $bks)
                                <option value="{{ $bks->bank_id }}">{{ $bks->bank_name }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>
                    <div class="col-sm-3">
                        <button type="button" id='income_report_in_all_submit' class="btn btn-success btn-sm ">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Search
                        </button>
                    </div>
				</div>
				</form>
				
            </div>
				<div id="income_report_in_all_table"></div>				
        </div>			
    </div>
</div>

@endsection