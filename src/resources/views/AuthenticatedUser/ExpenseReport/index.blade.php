@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')


<div class="row">
    <div class="col-sm-12">
	    <div class="panel panel-default">
            <div class="panel-heading"><strong> Expense Report </strong></div>
			
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
				
				<form class="form-horizontal" role="form" id="expense_report_form">
                    {{ csrf_field() }}
					
			    <div class="form-group form-group-sm">
					<label for="from_date" class="col-sm-2 control-label"> Date From <sup><i class="fa fa-asterisk"></i></sup> </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="from_date" name="from_date" placeholder="From"  readonly="readonly"/>
					</div>

					<label for="to_date" class="col-sm-2 control-label"> Date To <sup><i class="fa fa-asterisk"></i></sup></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="to_date" name="to_date" placeholder="To" value="{{ old('to_date') }}" readonly="readonly"/>
					</div>
		
                </div>
				 <div class="form-group form-group-sm">
					<label for="payment_type" class="col-sm-2 control-label"> Payment Type </label>
					<div class="col-sm-4">
						   <select id="payment_type" name="payment_type" class="form-control">
                               <option value="">--- Select ---</option>
							   
                               <option value='cash'> Cash </option>
                               <option value='check'> Check </option>
                               
                        </select>
					</div>
					<label for="version" class="col-sm-2 control-label"> Head Name </label>
					<div class="col-sm-4">
						   <select class="form-control" name="head_name" id="head_name">
                                <option value="">----- Select -----</option>
                                @if(isset($data['accountingHeads']))
                                @foreach($data['accountingHeads'] as $ft)
                                     <option value="{{ $ft->head_id }}">{{ $ft->head_name }}</option>
                                @endforeach
                                @endif
                            </select>
					</div>

                </div>
				<div class="form-group form-group-sm">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" id="expense_report_submit" class="btn btn-success btn-sm">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Search
                            </button>
                        </div>
                </div>
	
				</form>
				
            </div>
				<div id="expense_report_table"></div>				
        </div>			
    </div>
</div>

@endsection