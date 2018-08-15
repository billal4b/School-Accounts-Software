@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')


<div class="row">
    <div class="col-sm-12">
	    <div class="panel panel-default">
            <div class="panel-heading"><strong>Free Payment Report </strong></div>
			
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
				
				<form class="form-horizontal" role="form" id='free_payment_report_form'>
                    {{ csrf_field() }}
					
			  
				<div class="form-group form-group-sm">
					

					<label for="free_catagory" class="col-sm-2 control-label">Catagory</label>
					<div class="col-sm-4">
					    <select id="free_catagory" name="free_catagory" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['freeCategory']))
                                @foreach($data['freeCategory'] as $hds)
                                <option value="{{ $hds->stu_free_payment_id }}">{{ $hds->free_catagory }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>	
					<label for="branch_and_version" class="col-sm-2 control-label">Branch Name</label>
					<div class="col-sm-4">
					    <select id="branch_and_version" name="branch_and_version" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['secInstitutes']))
                                @foreach($data['secInstitutes'] as $hds)
                                <option value="{{ $hds->institute_branch_version_id }}">{{ $hds->school_branch_name }},
								{{ $hds->school_version_name }} </option>
                                @endforeach
                                @endif
                        </select>
					</div>	
					
                   				
                </div>
				<div class="form-group form-group-sm">
					

					
					<label for="class_name" class="col-sm-2 control-label">Class Name </label>
					<div class="col-sm-4">
					    <select id="class_name" name="class_name" class="form-control">
                                <option value="">--- Select ---</option>
                                @if(isset($data['classWise']))
                                @foreach($data['classWise'] as $hds)
                                <option value="{{ $hds->id }}">{{ $hds->ClassName }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>
						<label for="section_name" class="col-sm-2 control-label">Section Name</label>
					<div class="col-sm-4">
					    <select id="section_name" name="section_name" class="form-control">
                                <option value="">--- Select ---</option>
                              
                        </select>
					</div>
					
					
                   				
                </div>
				<div class="form-group form-group-sm">
								
					
					<label for="group_name" class="col-sm-2 control-label">Group Name </label>
					<div class="col-sm-4">
					    <select id="group_name" name="group_name" class="form-control">
                                <option value="">--- Select ---</option>
                                @if(isset($data['groupWise']))
                                @foreach($data['groupWise'] as $hds)
                                <option value="{{ $hds->id }}">{{ $hds->GroupName }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>
					
						<div class="col-sm-offset-0 col-sm-2">
						<button type="button" id='income_report_submit' class="btn btn-success btn-sm ">
							<i class="fa fa-floppy-o" aria-hidden="true"></i>
							Search 
						</button>
					    </div>
					  <div class="col-sm-2" id="wait" style="display: none;">
                            <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                          <span class="sr-only">Loading...</span>
                        </div>
				
					
                </div>
				
			
            
				
				</form>
				
            </div>
				<div id="free_payment_report_table"></div>				
        </div>			
    </div>
</div>

@endsection