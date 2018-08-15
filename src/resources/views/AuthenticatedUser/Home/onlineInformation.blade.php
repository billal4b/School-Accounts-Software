@extends('layouts.app')
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@section('main_content')


<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-default">
            <div class="panel-heading"><strong>Online Information </strong></div>
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


				 <div class="media">
				  <div class="media-left">
					
					  <img class="media-object" src="{{ asset('img/ProfilePicture') . '/' . Auth::user()->image }}" alt="{{ Auth::user()->image }}" class="img-responsive" width="200" height="150"/>
					
					<b><a href="#" data-toggle="modal" data-target="#myModal">Edit Picture</a></b>
				  </div>
				  <div class="media-body">
					<h4 class="media-heading">{{Auth::user()->full_name}}</h4>
								
						<!--<form class="form-horizontal">-->
						  
							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">E-mail </label>
								<div class="col-sm-4">
								  <p class="form-control-static">{{Auth::user()->email}}</p>
								</div>
								<label for="username" class="col-sm-2 control-label">Username </label>
								<div class="col-sm-4">
								  <p class="form-control-static">{{Auth::user()->username}}</p>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Phone No.  </label>
								<div class="col-sm-4">
								  <p class="form-control-static">{{Auth::user()->phone_no}}</p> 
								</div>					
							</div>
							
							
							
								  
							<div class="form-group">
								<div class="col-sm-10">
								  <a href="{{ url(route('home::updateOwnProfile')) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Update Profile</a>&nbsp;&nbsp;	  
								  <a href="{{ url(route('home::updateProfilePassword')) }}" class="btn btn-primary btn-sm"><i class="fa fa-key"></i> Change Password</a>  
								</div>
							</div>
						
					   <!--</form>-->											
				  </div>
				</div>

        </div>

    </div>
</div>
</div>
<!-- Modal content-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Your Profile Picture</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url(route('home::updateProfile')) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                  <div class="form-group form-group-sm">
                        <label for="image" class="col-sm-3 control-label">Select image </label>
                        <div class="col-sm-6">
                             <input type="file" name="image" id="image" value="{{ old('image') }}" />
                        </div>
                        @if ($errors->has('image'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('image') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-sm-offset-3 col-sm-10">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
   </div>
  </div>

@endsection