@extends('layouts.app')


@section('main_content')
<div class="row vertical-center">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Sign In</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url('Authentication/SignIn') }}">
                    
<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="identifiers"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Username or UserID or Email or Mobile No." aria-describedby="identifiers" name="identifiers" value="{{ old('identifiers') }}">
                            </div>
                            @if ($errors->has('identifiers'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('identifiers') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="password"><i class="fa fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="Password" aria-describedby="password" name="password">
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember">&nbsp;Remember me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm  pull-right">
                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                Sign In
                            </button>

<!--                            <a class="btn btn-link btn-sm" href="{{ url('/password/reset') }}">
                                Forgot Your Password?
                            </a>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection