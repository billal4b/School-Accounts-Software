@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Third Party Details  </strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('thirdParty.store')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="third_party_name" class="col-sm-2 control-label">Name<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="third_party_name" name="third_party_name" placeholder="Name" value="{{ old('third_party_name') }}">
                        </div>
                        @if ($errors->has('third_party_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_name') }}</strong>
                        </span>
                        @endif
                    </div>
					 <div class="form-group form-group-sm">
                        <label for="third_party_contact" class="col-sm-2 control-label">Contact No<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="third_party_contact" name="third_party_contact" placeholder="Contact No" value="{{ old('third_party_contact') }}">
                        </div>
                        @if ($errors->has('third_party_contact'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_contact') }}</strong>
                        </span>
                        @endif
                    </div>
					 
					
					 <div class="form-group form-group-sm">
                        <label for="third_party_details" class="col-sm-2 control-label">Details</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" id="third_party_details" name="third_party_details" placeholder="Details" value="{{ old('third_party_details') }}"></textarea>
                        </div>
                        @if ($errors->has('third_party_details'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_details') }}</strong>
                        </span>
                        @endif
                    </div>
					
					 <div class="form-group form-group-sm">
                        <label for="third_party_address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" id="third_party_address" name="third_party_address" placeholder="Address" value="{{ old('third_party_address') }}"></textarea>
                        </div>
                        @if ($errors->has('third_party_address'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_address') }}</strong>
                        </span>
                        @endif
                    </div>
					<div class="form-group form-group-sm">
                        <label for="third_party_open_balance" class="col-sm-2 control-label">Opening Balance<sup><i class="fa fa-asterisk"></i></sup> </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="third_party_open_balance" name="third_party_open_balance" placeholder="Opening Balance" value="{{ old('third_party_open_balance') }}">
                        </div>
                        @if ($errors->has('third_party_open_balance'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_open_balance') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="bank_status" class="col-sm-2 control-label">Status<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="third_party_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        @if ($errors->has('third_party_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_status') }}</strong>
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