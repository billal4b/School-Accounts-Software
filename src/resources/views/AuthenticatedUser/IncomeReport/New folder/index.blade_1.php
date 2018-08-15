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
				
				<form class="form-horizontal" role="form" id='income_report_form'>
                    {{ csrf_field() }}
					
			    <div class="form-group form-group-sm">
					<label for="from_date" class="col-sm-2 control-label"> Date From <sup><i class="fa fa-asterisk"></i></sup> </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="from_date" name="from_date" placeholder="From"  readonly="readonly"/>
					</div>

					<label for="to_date" class="col-sm-2 control-label"> Date To <sup><i class="fa fa-asterisk"> </i></sup></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="to_date" name="to_date" placeholder="To" value="{{ old('to_date') }}" readonly="readonly"/>
					</div>
					
                </div>
				<div class="form-group form-group-sm">
					

					<label for="branch_version_name" class="col-sm-2 control-label">Branch </label>
					<div class="col-sm-4">
					    <select id="branch_version_name" name="branch_version_name" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['secInstitutes']))
                                @foreach($data['secInstitutes'] as $hds)
                                <option value="{{ $hds->institute_branch_version_id }}">{{ $hds->school_branch_name }},
								{{ $hds->school_version_name }} </option>
                                @endforeach
                                @endif
                        </select>
					</div>	
                    <label for="head_name" class="col-sm-2 control-label"> Head </label>
					<div class="col-sm-4">
						<select id="head_name" name="head_name" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['headWise']))
                                @foreach($data['headWise'] as $hds)
                                <option value="{{ $hds->student_payment_name }}">{{ $hds->student_payment_name }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>					
                </div>
				<div class="form-group form-group-sm">
									
					
					<label for="class_name" class="col-sm-2 control-label">Class </label>
					<div class="col-sm-2">
					    <select id="class_name" name="class_name" class="form-control">
                                <option value="">--- Select ---</option>
                                @if(isset($data['classWise']))
                                @foreach($data['classWise'] as $hds)
                                <option value="{{ $hds->id }}">{{ $hds->ClassName }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>
					
					<label for="section_name" class="col-sm-2 control-label">Section </label>
					<div class="col-sm-2">
					    <select id="section_name" name="section_name" class="form-control">
                                <option value="">--- Select ---</option>
                                @if(isset($data['sectionWise']))
                                @foreach($data['sectionWise'] as $hds)
                                <option value="{{ $hds->section_id }}">{{ $hds->SectionName }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>	
					<label for="group_name" class="col-sm-2 control-label">Group </label>
					<div class="col-sm-2">
					    <select id="group_name" name="group_name" class="form-control">
                                <option value="">--- Select ---</option>
                                @if(isset($data['groupWise']))
                                @foreach($data['groupWise'] as $hds)
                                <option value="{{ $hds->id }}">{{ $hds->GroupName }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>
                </div>
				<div class="form-group form-group-sm">					
					<label for="report_type" class="col-sm-2 control-label">Report Type <sup><i class="fa fa-asterisk"></i></sup></label>					
					    <div class="col-sm-4">
                            <select class="form-control" id="report_type" name="report_type">                               
                                <option value="summary">Summary</option>
                                <option value="details">Details</option>
                            </select>
                        </div>
						<div class="col-sm-4">
						<button type="button" id='income_report_submit' class="btn btn-success btn-sm ">
							<i class="fa fa-floppy-o" aria-hidden="true"></i>
							Search 
						</button>
					    </div>
				
                </div>
				</form>
				
            </div>
				<div id="income_report_table"></div>				
        </div>			
    </div>
</div>

@endsection