@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')


<div class="row">
    <div class="col-sm-12">
	    <div class="panel panel-default">
            <div class="panel-heading"><strong> Free Payment Details </strong></div>
			
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
				<form class="form-horizontal" role="form" method="POST" action="{{ url(route('freePaymentDetails.store')) }}" >
                    {{ csrf_field() }}			
					
				<div class="form-group form-group-sm">				
					<label for="branch_and_version" class="col-sm-2 control-label">Branch  <sup><i class="fa fa-asterisk"></i></sup></label>
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
					<label for="class_name" class="col-sm-2 control-label">Class  <sup><i class="fa fa-asterisk"></i></sup></label>
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
										
					<label for="group_name" class="col-sm-2 control-label">Group  <sup><i class="fa fa-asterisk"></i></sup></label>
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
                    <label for="head_name" class="col-sm-2 control-label"> Head  <sup><i class="fa fa-asterisk"></i></sup></label>
					<div class="col-sm-4">
					    <select id="head_name" name="head_name" class="form-control">
                               <option value="">--- Select ---</option>                              
                        </select>
					</div>
					
                </div>
				<div class="form-group form-group-sm">								
										
					<label for="free_catagory" class="col-sm-2 control-label"> Category   <sup><i class="fa fa-asterisk"></i></sup></label>
					<div class="col-sm-4">
					    <select id="free_catagory" name="free_catagory" class="form-control">
                                <option value="">--- Select ---</option>
                                @if(isset($data['freePayment']))
                                @foreach($data['freePayment'] as $hds)
                                <option value="{{ $hds->stu_free_payment_id }}">{{ $hds->free_catagory }}</option>
                                @endforeach
                                @endif
                        </select>
					</div>	
                    <label for="amount" class="col-sm-2 control-label"> Amount <sup><i class="fa fa-asterisk"></i></sup></label>
					<div class="col-sm-4">
					    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" value="{{ old('amount') }}">
					</div>
					
                </div>
				 <div class="form-group form-group-sm">
					
                        <label for="status" class="col-sm-2 control-label">Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="status">
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