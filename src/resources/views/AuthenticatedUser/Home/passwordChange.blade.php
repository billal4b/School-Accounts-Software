@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Change Your Password</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('home::updatePasswordAction')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="oldpassword" class="col-sm-3 control-label">Current  Password <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="oldpassword" name="oldpassword" Placeholder="Current  Password"/>
                        </div>
                        @if ($errors->has('oldpassword'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('oldpassword') }}</strong>
                        </span>
                        @endif
                    </div>
					<div class="form-group form-group-sm">
                        <label for="password" class="col-sm-3 control-label">New Password <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="password" name="password" Placeholder="New Password"/>
                        </div>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
					<div class="form-group form-group-sm">
                        <label for="cnfpassword" class="col-sm-3 control-label">Conform Password <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="cnfpassword" name="cnfpassword" Placeholder="Conform Password"/>
                        </div>
                        @if ($errors->has('cnfpassword'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('cnfpassword') }}</strong>
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