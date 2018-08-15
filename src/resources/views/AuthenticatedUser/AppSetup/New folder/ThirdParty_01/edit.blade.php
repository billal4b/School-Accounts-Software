@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Third Party Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('thirdParty.update', array('id' => $data['thirdPartyDetails']->third_party_id))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    <div class="form-group form-group-sm">
                        <label for="third_party_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="third_party_name" name="third_party_name" placeholder="Third Party Name" value="{{ $data['thirdPartyDetails']->third_party_name }}">
                        </div>
                        @if ($errors->has('third_party_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_name') }}</strong>
                        </span>
                        @endif
                    </div>
					 <div class="form-group form-group-sm">
                        <label for="third_party_details" class="col-sm-2 control-label">Details</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="third_party_details" name="third_party_details" placeholder="Third Party Details" value="{{ $data['thirdPartyDetails']->third_party_details }}">
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
                            <input type="text" class="form-control" id="third_party_address" name="third_party_address" placeholder="Third Party Address" value="{{ $data['thirdPartyDetails']->third_party_address }}">
                        </div>
                        @if ($errors->has('third_party_address'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_address') }}</strong>
                        </span>
                        @endif
                    </div>
					 <div class="form-group form-group-sm">
                        <label for="third_party_category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="third_party_category" name="third_party_category" placeholder="Third Party category" value="{{ $data['thirdPartyDetails']->third_party_category }}">
                        </div>
                        @if ($errors->has('third_party_category'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('third_party_category') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="third_party_status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="third_party_status" id="third_party_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                            <script type="text/javascript">
                                document.getElementById('third_party_status').value = '{{ $data['thirdPartyDetails']->is_active }}';
                            </script>
                        </div>
                        @if ($errors->has('third_party_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('thirdParty') }}</strong>
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