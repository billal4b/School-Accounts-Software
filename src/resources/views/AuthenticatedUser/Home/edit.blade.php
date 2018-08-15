@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Update Your Profile</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('home::updateOwnProfileAction')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="full_name" class="col-sm-2 control-label">Full Name<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{Auth::user()->full_name}}">
                        </div>
                        @if ($errors->has('full_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('full_name') }}</strong>
                        </span>
                        @endif
                    </div>
					 <div class="form-group form-group-sm">
                        <label for="email" class="col-sm-2 control-label">E-mail<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email"  value="{{ Auth::user()->email }}">
                        </div>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
					
					
					 <div class="form-group form-group-sm">
                        <label for="phone_no" class="col-sm-2 control-label">Phone No<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">                                                        
                            <input type="text" class="form-control" id="phone_no" name="phone_no"  value="{{ Auth::user()->phone_no }}">
                        </div>
                        @if ($errors->has('phone_no'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('phone_no') }}</strong>
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