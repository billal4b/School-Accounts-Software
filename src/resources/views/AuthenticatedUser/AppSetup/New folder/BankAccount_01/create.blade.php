@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Bank Account Create</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('bankAccount.store')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="account_no" class="col-sm-2 control-label">Account Number</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="account_no" name="account_no" placeholder="Bank Account" value="{{ old('account_no') }}">
                        </div>
                        @if ($errors->has('account_no'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('account_no') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="bank_name" class="col-sm-2 control-label">Bank Name</label>
                        <div class="col-sm-6">
                            <select id="bank_name" name="bank_name" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['banks']))
                                @foreach($data['banks'] as $bnks)
                                <option value="{{ $bnks->bank_id }}">{{ $bnks->bank_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('bank_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('bank_name') }}</strong>
                        </span>
                        @endif
                    </div>
		<div class="form-group form-group-sm">
                        <label for="branch_name" class="col-sm-2 control-label">Branch Name</label>
                        <div class="col-sm-6">
                            <select id="branch_name" name="branch_name" class="form-control">
                                <option value="">----- Select -----</option>
                            </select>
                        </div>
                        @if ($errors->has('branch_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('branch_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="account_status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="account_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        @if ($errors->has('account_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('account_status') }}</strong>
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