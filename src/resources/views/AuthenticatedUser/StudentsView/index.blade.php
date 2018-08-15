@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')


<div class="row">
    <div class="col-sm-12">
	    <div class="panel panel-default">
            <div class="panel-heading"><strong> Students View </strong></div>
			
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
				
				<form class="form-horizontal" role="form" id='students_view_form' onsubmit="return false;" >
                    {{ csrf_field() }}			
					
				<div class="form-group form-group-sm">				
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
                </div>
				<div class="form-group form-group-sm">								
						<label for="section_name" class="col-sm-2 control-label">Section Name</label>
					<div class="col-sm-4">
					    <select id="section_name" name="section_name" class="form-control">
                               <option value="">--- Select ---</option>                              
                        </select>
					</div>					
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
                </div>
				<div class="form-group form-group-sm">	
				    <label for="students_view_submit" class="col-sm-2 control-label"></label>
					<div class="col-sm-4">
						<button type="button" id='students_view_submit' class="btn btn-success btn-sm ">
							<i class="fa fa-search" aria-hidden="true"></i>
							Search 
						</button>
					</div>				
                </div>							
				</form>				
            </div>
				<div id="students_view_table"></div>				
        </div>			
    </div>
</div>
@endsection