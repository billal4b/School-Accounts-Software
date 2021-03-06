@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')


<div class="row">
    <div class="col-sm-12">
	    <div class="panel panel-default">
            <div class="panel-heading"><strong>Student Payment Confirmation Report </strong></div>
			
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
				
				<form class="form-horizontal" role="form" id='confirmation_report_form'>
                    {{ csrf_field() }}
					
			    <div class="form-group form-group-sm">
					<label for="from_date" class="col-sm-2 control-label"> Date From <sup><i class="fa fa-asterisk"></i></sup> </label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="from_date" name="from_date" placeholder="From"  readonly="readonly"/>
					</div>

					<label for="to_date" class="col-sm-2 control-label"> Date To <sup><i class="fa fa-asterisk"></i></sup></label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="to_date" name="to_date" placeholder="To" value="{{ old('to_date') }}" readonly="readonly"/>
					</div>
					<div class="col-sm-2">
						<button type="button" id='payment_confirmation_report_view' class="btn btn-success btn-sm">
							<i class="fa fa-search" aria-hidden="true"></i>
							Search 
						</button>
					</div>
                </div>
				</form>
				
            </div>
				<div id="payment_confirmation_report"></div>				
        </div>			
    </div>
</div>

@endsection