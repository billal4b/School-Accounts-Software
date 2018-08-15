@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Bank Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('bank.store')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="bank_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="{{ old('bank_name') }}">
                        </div>
                        @if ($errors->has('bank_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('bank_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="bank_status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="bank_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        @if ($errors->has('bank_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('bank_status') }}</strong>
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