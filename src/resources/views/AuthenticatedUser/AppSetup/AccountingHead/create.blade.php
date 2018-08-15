@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Accounting Head Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('head.store')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="head_name" class="col-sm-2 control-label">Head Name<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="head_name" name="head_name" placeholder="Accounting Head Name" value="{{ old('head_name') }}">
                        </div>
                        @if ($errors->has('head_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('head_name') }}</strong>
                        </span>
                        @endif
                    </div>
					 <div class="form-group form-group-sm">
                        <label for="account_category_name" class="col-sm-2 control-label">Account Category<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select id="account_category_name" name="account_category_name" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['categories']))
                                @foreach($data['categories'] as $ctgs)
                                <option value="{{ $ctgs->account_category_id}}">{{ $ctgs->account_category_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('account_category_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('account_category_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="head_status" class="col-sm-2 control-label">Status<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="head_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        @if ($errors->has('head_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('head_status') }}</strong>
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