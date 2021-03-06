@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Update Bank Account Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('bankAccount.update', array('id' => $data['bankAccountDetails']->account_id))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    <div class="form-group form-group-sm">
                        <label for="account_no" class="col-sm-2 control-label">Account Numner<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="account_no" name="account_no" placeholder="Bank Name" value="{{ $data['bankAccountDetails']->account_no }}">
                        </div>
                        @if ($errors->has('account_no'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('account_no') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="bank_name" class="col-sm-2 control-label">Bank Name<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select id="bank_name" name="bank_name" class="form-control">
                                <option value="">----- Select -----</option>       
								    @if(isset($data['banks']))
                                    @foreach($data['banks'] as $bnks)
                                <option value="{{ $bnks->bank_id }}">{{ $bnks->bank_name }}</option>
                                    @endforeach      
                                    @endif
                            </select>
							<script type="text/javascript">
                                document.getElementById('bank_name').value = '{{ $data['bankAccountDetails']->bank_id}}';
                            </script>
                        </div>
                        @if ($errors->has('bank_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('bank_name') }}</strong>
                        </span>
                        @endif
                    </div>
		           <div class="form-group form-group-sm">
                        <label for="branch_name" class="col-sm-2 control-label">Branch Name<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select id="branch_name" name="branch_name" class="form-control">
                                <option value="">----- Select -----</option>
								    @if(isset($data['branches']))
                                    @foreach($data['branches'] as $bnks)
                                    <option value="{{ $bnks->branch_id }}">{{ $bnks->branch_name }}</option>
                                    @endforeach 
									@endif
                            </select>
							<script type="text/javascript">
                                document.getElementById('branch_name').value = '{{ $data['bankAccountDetails']->branch_id}}';
                            </script>
                        </div>
                        @if ($errors->has('branch_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('branch_name') }}</strong>
                        </span>
                        @endif
                    </div>
					
					<div class="form-group form-group-sm">
                        <label for="contact_no" class="col-sm-2 control-label">Contact Number</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $data['bankAccountDetails']->contact_no }}">
                        </div>
                        @if ($errors->has('contact_no'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('contact_no') }}</strong>
                        </span>
                        @endif
                    </div>
					<div class="form-group form-group-sm">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" id="address" name="address" >{{ $data['bankAccountDetails']->address }}</textarea>
                        </div>
                        @if ($errors->has('address'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>
					<div class="form-group form-group-sm">
                        <label for="opening_balance" class="col-sm-2 control-label">Opening Balance<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="opening_balance" name="opening_balance" value="{{ $data['bankAccountDetails']->opening_balance }}">
                        </div>
                        @if ($errors->has('opening_balance'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('opening_balance') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="account_status" class="col-sm-2 control-label">Status<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="account_status" id="account_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                            <script type="text/javascript">
                                document.getElementById('account_status').value = '{{ $data['bankAccountDetails']->is_active }}';
                            </script>
                        </div>
                        @if ($errors->has('account_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('bankAccount') }}</strong>
                        </span>
                        @endif
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