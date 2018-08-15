@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>{{ $data['pageType'] or '&nbsp;' }} Details</strong></div>
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


                    <form class="form-horizontal" role="form" method="POST"
				action="{{ url(route('3in1p', array('id'=>$data['pageType']))) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="invoice_no" class="col-sm-2 control-label">Invoice No. <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No." value="{{ old('invoice_no') }}">
                        </div>                  

                        <label for="dateOf" class="col-sm-2 control-label">Date <sup><i class="fa fa-asterisk"></i> </sup> </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="dateOf" name="dateOf" placeholder="Date of {{ $data['pageType'] or '&nbsp;' }}" value="{{ old('dateOf') }}" readonly="readonly">
                        </div>
                      
                    </div>

                    <div class="form-group form-group-sm">

                    </div>

                    <div class="form-group form-group-sm">
                        <label for="payment_type" class="col-sm-2 control-label">Payment Type <sup><i class="fa fa-asterisk"> </i> </sup></label>
                        <div class="col-sm-4">
                            <label class="radio-inline">
                                <input type="radio" name="payment_type" id="payment_type_Cash" value="cash" checked> Cash
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="payment_type" id="payment_type_Check" value="check"> Check
                            </label>
                        </div>
                   
                        <label for="head_name" class="col-sm-2 control-label">Head Name <sup> <i class="fa fa-asterisk"></i> </sup> </label>
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
                        <div class="col-sm-12">
                            <div id="subHeadLists"></div>
                        </div>
                    </div>
                    
                    <div id="bank_info" style="display: none">
                    <div class="form-group form-group-sm">
                        <label for="bank_name" class="col-sm-2 control-label">Bank Name <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="bank_name" id="bank_name">
                                <option value="">----- Select -----</option>
                                @if(isset($data['banks']))
                                @foreach($data['banks'] as $bnks)
                                   <option value="{{ $bnks->bank_id }}">{{ $bnks->bank_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <label for="branch_name" class="col-sm-2 control-label">Branch Name <sup><i class="fa fa-asterisk"> </i> </sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="branch_name" id="branch_name">
                                <option value="">----- Select -----</option>
								@if(isset($data['branches']))
                                @foreach($data['branches'] as $bnks)
                                   <option value="{{ $bnks->branch_id }}">{{ $bnks->branch_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="account_no" class="col-sm-2 control-label">Account No. <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="account_no" id="account_no">
                                <option value="">----- Select -----</option>
								@if(isset($data['accounts']))
                                @foreach($data['accounts'] as $bnks)
                                   <option value="{{ $bnks->account_id }}">{{ $bnks->account_no }}</option>
                                @endforeach
                                @endif
								
                            </select>
                        </div>
                
                        <label for="check_no" class="col-sm-2 control-label">Check No. <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="check_no" name="check_no" placeholder=" Check No. "/>
                        </div>
                
                    </div>
                    <div class="form-group form-group-sm">
					   
                        <label for="check_date" class="col-sm-2 control-label">Check Date <sup><i class="fa fa-asterisk"></i> </sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="check_date" name="check_date"  placeholder=" Check Date "  readonly="readonly"/>
                        </div>
                    
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